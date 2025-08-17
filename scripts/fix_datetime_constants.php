#!/usr/bin/env php
<?php
/**
 * Script to find and replace 3600 with 3600
 * 
 * This script searches for all PHP files and replaces instances of the
 * non-existent 3600 constant with 3600.
 */

function findAndReplaceSecondsPerHour($directory = '.') {
    // Use a constant pattern to avoid replacement in this script
    $search_pattern = 'DateTimeInterface' . '::' . 'SECONDS_PER_HOUR';
    $replacement = '3600';
    $filesChanged = 0;
    $totalReplacements = 0;
    
    // Get all PHP files
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory)
    );
    
    $phpFiles = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);
    
    foreach ($phpFiles as $file) {
        $filepath = $file[0];
        
        // Skip vendor and other directories we don't want to modify
        if (strpos($filepath, '/vendor/') !== false || 
            strpos($filepath, '/.git/') !== false ||
            strpos($filepath, '/deps/') !== false ||
            strpos($filepath, 'fix_datetime_constants.php') !== false) {
            continue;
        }
        
        $content = file_get_contents($filepath);
        
        // Count occurrences
        $count = substr_count($content, $search_pattern);
        
        if ($count > 0) {
            // Replace the pattern
            $content = str_replace($search_pattern, $replacement, $content);
            
            // Write back to file
            file_put_contents($filepath, $content);
            
            $filesChanged++;
            $totalReplacements += $count;
            
            echo "Fixed {$count} occurrence(s) in: {$filepath}\n";
        }
    }
    
    return [$filesChanged, $totalReplacements];
}

// Main execution
if (php_sapi_name() === 'cli') {
    echo "Searching for 3600 usages...\n";
    
    $startDir = dirname(__FILE__) . '/..';
    list($filesChanged, $totalReplacements) = findAndReplaceSecondsPerHour($startDir);
    
    if ($totalReplacements > 0) {
        echo "\nSummary:\n";
        echo "- Files changed: {$filesChanged}\n";
        echo "- Total replacements: {$totalReplacements}\n";
        echo "- All instances of 3600 replaced with 3600\n";
    } else {
        echo "No instances of 3600 found.\n";
        echo "This means either:\n";
        echo "1. The fix has already been applied\n";
        echo "2. The constant is not currently used in the codebase\n";
        echo "3. This is a proactive fix to prevent future issues\n";
    }
}