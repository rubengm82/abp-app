<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the about page with software licenses information
     */
    public function show()
    {
        // Get Laravel version
        $laravelVersion = app()->version();
        
        // Get PHP version
        $phpVersion = PHP_VERSION;
        
        // Extract versions from dependencies
        $dependencies = [
            'laravel' => $laravelVersion,
            'php' => $phpVersion,
        ];
        
        // Read package.json to get frontend dependency versions
        $packagePath = base_path('package.json');
        if (file_exists($packagePath)) {
            $packageJson = json_decode(file_get_contents($packagePath), true);
            
            // Get frontend dependencies from package.json
            if (isset($packageJson['dependencies'])) {
                foreach ($packageJson['dependencies'] as $package => $version) {
                    $dependencies[$package] = $version;
                }
            }
            
            if (isset($packageJson['devDependencies'])) {
                foreach ($packageJson['devDependencies'] as $package => $version) {
                    if (in_array($package, ['tailwindcss', 'daisyui', 'vite'])) {
                        $dependencies[$package] = $version;
                    }
                }
            }
        }
        
        return view('components.contents.about.aboutShow', [
            'dependencies' => $dependencies
        ]);
    }
}

