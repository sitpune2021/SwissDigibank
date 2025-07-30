@if(session('success'))
<div class="flex flex-col gap-4 lg:gap-6 pt-5" id="success-alert">
    <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-primary/20 flex justify-between items-center">
        <div class="flex gap-5 items-center">
            <i class="las la-info-circle text-3xl text-primary"></i>
            <span class="l-text font-medium text-primary"> {{ session('success')}}</span>
        </div>
    </div>
</div>
@endif
@if(session('error'))
<div class="flex flex-col gap-4 lg:gap-6 pt-5" id="error-alert">
    <div class="py-3 px-4 md:px-6 lg:px-8 rounded-xl bg-error/20 flex justify-between items-center">
        <div class="flex gap-5 items-center">
            <i class="las la-exclamation-triangle text-3xl text-error"></i>
            <span class="l-text font-medium text-error">{{ session('error')}}</span>
        </div>
        <span class="cursor-pointer size-9 rounded-full hover:bg-error/30 duration-300 f-center">
            <i class="las la-times text-2xl text-error"></i>
        </span>
    </div>
</div>
@endif

<script>
    setTimeout(() => {
        const successAlert = document.getElementById('success-alert');
        const errorAlert = document.getElementById('error-alert');

        if (successAlert) successAlert.remove();
        if (errorAlert) errorAlert.remove();
    }, 5000);
</script>