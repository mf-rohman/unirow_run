<div class="max-w-3xl mx-auto p-6">
    
    <form wire:submit="create">
        {{ $this->form }}

        <div class="mt-4 mb-4 flex justify-center">
            <div class="g-recaptcha" 
                 data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"
                 wire:ignore>
            </div>
        </div>

        <!-- <button type="submit"
            class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 transition mt-4">
            DAFTAR SEKARANG
        </button> -->
    </form>
    
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</div>