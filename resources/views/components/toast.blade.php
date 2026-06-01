<!-- Toast diletakkan di global layout -->
<div id="toast-container" class="fixed bottom-4 right-4 z-[200] flex flex-col gap-2"></div>

<!-- Toast Template -->
<template id="toast-template">
    <div class="toast-item flex items-center w-full max-w-xs p-4 text-text-dark bg-white rounded-md shadow-lg border border-border-color transition-all duration-300 transform translate-x-full opacity-0" role="alert">
        <div class="toast-icon inline-flex items-center justify-center flex-shrink-0 w-8 h-8 rounded-lg">
            <!-- Icon -->
        </div>
        <div class="toast-message ml-3 text-sm font-medium"></div>
        <button type="button" class="toast-close ml-auto -mx-1.5 -my-1.5 bg-white text-text-gray hover:text-text-dark rounded-md p-1.5 inline-flex items-center justify-center h-8 w-8 focus:ring-2 focus:ring-border-color">
            <span class="sr-only">Close</span>
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</template>