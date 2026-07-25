<div x-data="{ loading: false }">
    <button 
        wire:click="loginWithGoogle"
        @click="loading = true"
        :disabled="loading"
        class="btn btn-outline-secondary w-100">
        
        <span x-show="!loading">
            <img src="https://www.google.com/favicon.ico" class="me-2" style="height: 1.25rem;">
            Masuk dengan Google
        </span>

        <span x-show="loading" x-cloak>
            <span class="spinner-border spinner-border-sm me-2"></span>
            Loading...
        </span>
    </button>
</div>