<?php
/**
 * Fix SQL Import Issues for Laragon
 * This script fixes common issues when importing SQL from XAMPP to Laragon
 */

function fixSqlFile($inputFile, $outputFile) {
    if (!file_exists($inputFile)) {
        echo "Error: File $inputFile not found!\n";
        return false;
    }
    
    $content = file_get_contents($inputFile);
    
    // Fix 1: Replace TRUNCATE with DELETE for tables with foreign keys
    $tablesWithForeignKeys = [
        'bimbingan_konseling',
        'monitoring_pelanggaran', 
        'pelaksanaan_sanksi',
        'sanksi',
        'pelanggaran',
        'prestasi',
        'verifikasi_data',
        'siswa',
        'kelas'
    ];
    
    foreach ($tablesWithForeignKeys as $table) {
        $content = str_replace(
            "TRUNCATE TABLE $table;",
            "DELETE FROM $table;",
            $content
        );
    }
    
    // Fix 2: Add foreign key constraint handling
    $foreignKeyFix = "-- Disable foreign key checks\nSET FOREIGN_KEY_CHECKS = 0;\n\n";
    $foreignKeyRestore = "\n-- Re-enable foreign key checks\nSET FOREIGN_KEY_CHECKS = 1;\n";
    
    // Find the first TRUNCATE or DELETE statement
    $firstDeletePos = strpos($content, 'TRUNCATE TABLE');
    if ($firstDeletePos === false) {
        $firstDeletePos = strpos($content, 'DELETE FROM');
    }
    
    if ($firstDeletePos !== false) {
        $content = substr_replace($content, $foreignKeyFix, $firstDeletePos, 0);
        $content .= $foreignKeyRestore;
    }
    
    // Fix 3: Handle AUTO_INCREMENT issues
    $content = preg_replace('/AUTO_INCREMENT=\d+/', 'AUTO_INCREMENT=1', $content);
    
    // Fix 4: Replace MD5 with bcrypt for passwords (Laravel standard)
    $content = str_replace("MD5('", "'\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'", $content);
    
    // Write fixed content
    file_put_contents($outputFile, $content);
    
    echo "Fixed SQL file saved as: $outputFile\n";
    return true;
}

// Fix the main SQL files
$filesToFix = [
    'public/db_pelanggaran.sql' => 'db_pelanggaran_fixed.sql',
    'sippres.sql' => 'sippres_fixed.sql',
    'public/sample_data_fixed.sql' => 'sample_data_laragon.sql'
];

echo "===========================================\n";
echo "SQL IMPORT FIXER FOR LARAGON\n";
echo "===========================================\n\n";

foreach ($filesToFix as $input => $output) {
    if (file_exists($input)) {
        echo "Processing: $input\n";
        fixSqlFile($input, $output);
        echo "✓ Fixed: $output\n\n";
    } else {
        echo "⚠ Skipped: $input (file not found)\n\n";
    }
}

echo "===========================================\n";
echo "IMPORT INSTRUCTIONS:\n";
echo "===========================================\n";
echo "1. Use the *_fixed.sql files instead of original\n";
echo "2. Or run: import_safe.bat\n";
echo "3. Or use: mysql -u root sippres < filename_fixed.sql\n";
echo "===========================================\n";
?>