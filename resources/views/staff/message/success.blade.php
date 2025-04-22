
@if(session()->has('success'))

<div role="alert" id='status' class="mb-7 w-fit  z-50 mx-auto fixed top-[80px] right-1 flex flex-row items-center justify-center  p-3 px-4 gap-3 bg-green-600 border border-none rounded-xs font-regular">
    <i class="fa-solid fa-check text-md font-bold text-white"></i>
    <p  id="status_text" class='text-white text-md font-bold mr-8'>{{session('success')}}</p>
</div>

<script>  
    setTimeout(() => {
        const statusDiv = document.getElementById('status');
        if (statusDiv) {
            statusDiv.classList.add('hidden');
        }
    }, 4000); 
</script>

@endif