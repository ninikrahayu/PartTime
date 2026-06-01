@props(['name', 'label' => 'Upload File', 'accept' => ''])
<div class="flex items-center justify-center w-full">
    <label for="dropzone-file-{{ $name }}" class="flex flex-col items-center justify-center w-full h-32 border-2 border-border-color border-dashed rounded-md cursor-pointer bg-surface hover:bg-gray-100 transition-colors">
        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-text-gray">
            <i class="fa-solid fa-cloud-arrow-up text-2xl mb-2"></i>
            <p class="mb-1 text-sm"><span class="font-semibold">{{ $label }}</span> atau seret file ke sini</p>
            <p class="text-xs text-text-gray">PDF, JPG, PNG (Max. 2MB)</p>
        </div>
        <input id="dropzone-file-{{ $name }}" type="file" name="{{ $name }}" class="hidden" accept="{{ $accept }}" onchange="this.previousElementSibling.querySelector('p').textContent = this.files[0] ? this.files[0].name : '{{ $label }} atau seret file ke sini'" />
    </label>
</div>