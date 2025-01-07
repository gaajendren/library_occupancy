@if(session()->has('error'))
<div role="alert" id='status' class="mb-7 max-w-[450px] mx-auto relative flex w-full p-3 gap-3 bg-red-100 border border-red-400 rounded-lg font-regular">
    <p  id="status_text" class='text-red-700 text-lg'>{{session('error')}}</p>
    <button onclick="document.getElementById('status').classList.toggle('hidden')" class="flex items-center justify-center transition-all w-8 h-8 rounded-md text-white hover:bg-slate-100 active:bg-slate-100 absolute top-2.5 right-2.5" type="button">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5 text-red-600" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
    </button>
</div>

<script>  
    setTimeout(() => {
        const statusDiv = document.getElementById('status');
        if (statusDiv) {
            statusDiv.classList.add('hidden');
        }
    }, 5000); 
</script>

@endif