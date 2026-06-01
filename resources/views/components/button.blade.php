<button {{ $attributes->merge(['class' => 'inline-flex justify-center items-center px-4 py-2 bg-primary border border-transparent rounded-md font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed']) }}>
    {{ $slot }}
</button>