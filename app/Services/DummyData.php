<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class DummyData
{
    protected static $data = null;

    /**
     * Load data from dummy-data.json if not already loaded.
     */
    protected static function loadData()
    {
        if (self::$data === null) {
            $path = storage_path('app/dummy-data.json');
            
            if (File::exists($path)) {
                $json = File::get($path);
                self::$data = json_decode($json, true) ?? [];
            } else {
                self::$data = [];
            }
        }
        
        return self::$data;
    }

    /**
     * Get a specific key from the dummy data using dot notation.
     * 
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        $data = self::loadData();
        
        if ($key === null) {
            return $data;
        }
        
        return data_get($data, $key, $default);
    }

    /**
     * Get collection of items and optionally filter by key-value pair
     * 
     * @param string $key e.g., 'jobs', 'users'
     * @param string|null $filterKey
     * @param mixed $filterValue
     * @return \Illuminate\Support\Collection
     */
    public static function getCollection($key, $filterKey = null, $filterValue = null)
    {
        $items = collect(self::get($key, []));
        
        if ($filterKey !== null && $filterValue !== null) {
            return $items->where($filterKey, $filterValue)->values();
        }
        
        return $items;
    }
    
    /**
     * Find a single item by ID
     * 
     * @param string $key e.g., 'jobs', 'users'
     * @param string $id
     * @return array|null
     */
    public static function findById($key, $id)
    {
        $items = collect(self::get($key, []));
        return $items->firstWhere('id', $id);
    }
}
