{{-- @if(session('success'))
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
--}}


<style>
.alert-box{
    position: fixed;
    top: 150px;
    right: 200px;
    z-index: 9999;
    min-width: 320px;
    max-width: 420px;
    border-radius: 12px;
    padding: 14px 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    animation: slideIn 0.4s ease;
    font-family: inherit;
}

.alert-box.success{
    background: rgb(34,197,94);
    color: #ffffff;
}

.alert-box.error{
    background: rgba(239,68,68,0.15);
    color: #dc2626;
}

.alert-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
}

.alert-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.alert-icon{
    font-size:26px;
}

.alert-text{
    font-weight:500;
}

.alert-close{
    cursor:pointer;
    width:34px;
    height:34px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    transition:.25s;
}

.alert-box.error .alert-close:hover{
    background: rgba(239,68,68,0.25);
}

@keyframes slideIn{
    from{
        transform: translateX(120%);
        opacity:0;
    }
    to{
        transform: translateX(0);
        opacity:1;
    }
}
</style>


@if(session('success'))
<div id="success-alert" class="alert-box success">
    <div class="alert-content">
        <div class="alert-left">
            <i class="las la-info-circle alert-icon"></i>
            <span class="alert-text">{{ session('success') }}</span>
        </div>
    </div>
</div>
@endif

@if(session('error'))
<div id="error-alert" class="alert-box error">
    <div class="alert-content">
        <div class="alert-left">
            <i class="las la-exclamation-triangle alert-icon"></i>
            <span class="alert-text">{{ session('error') }}</span>
        </div>
        <span class="alert-close" onclick="this.closest('.alert-box').remove()">
            <i class="las la-times"></i>
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