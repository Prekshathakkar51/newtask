<div
    x-data
    x-show="$store.toast.show"
    x-transition
    x-cloak
    class="fixed top-6 right-6 z-[999999] w-[320px]"
    :class="{
        'bg-green-600': $store.toast.type === 'success',
        'bg-red-600': $store.toast.type === 'error',
        'bg-blue-600': $store.toast.type === 'info',
        'bg-yellow-500': $store.toast.type === 'warning',
    }"
>
    <div class="text-white p-4 rounded-lg shadow-lg flex justify-between">
        
        <div>
            <p class="font-semibold" x-text="$store.toast.title"></p>
            <p class="text-sm opacity-90" x-text="$store.toast.message"></p>
        </div>

        <button @click="$store.toast.hide()">✕</button>

    </div>
</div>