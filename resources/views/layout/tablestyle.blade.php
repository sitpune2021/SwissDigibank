<style>

@keyframes fadeRow{
0%{
opacity:0;
transform:translateY(10px);
}
100%{
opacity:1;
transform:translateY(0);
}
}

.table-row{
animation:fadeRow .4s ease forwards;
}

/* hover animation */

.table-row:hover{
transform:scale(1.01);
box-shadow:0 4px 12px rgba(0,0,0,0.08);
transition:all .25s ease;
}

</style>

<style>
/* =========================
    ACTION BUTTONS
========================= */

.action-btn{

    height:36px;
    min-width:82px;

    display:flex;
    align-items:center;
    justify-content:center;
    gap:6px;

    padding:0 12px;

    border-radius:10px;

    font-size:13px;
    font-weight:600;

    color:#fff;

    transition:.25s ease;
}

.action-btn:hover{
    transform:translateY(-1px);
}

/* VIEW */

.action-view{
    background:linear-gradient(135deg,#2563eb,#06b6d4);
}

/* EDIT */

.action-edit{
    background:linear-gradient(135deg,#f59e0b,#f97316);
}

/* MOBILE */

@media(max-width:768px){

    .action-btn{

        min-width:70px;
        height:32px;

        padding:0 10px;

        font-size:12px;

        border-radius:8px;
    }
}
</style>

<style>

/* =========================
    PAGE ENTRY ANIMATION
========================= */

@keyframes pageReveal{

    0%{
        opacity:0;
        transform:scale(.985) translateY(16px);
        filter:blur(8px);
    }

    60%{
        opacity:1;
        transform:scale(1.005) translateY(-2px);
        filter:blur(0);
    }

    100%{
        opacity:1;
        transform:scale(1) translateY(0);
        filter:blur(0);
    }
}

/* MAIN BOX PREMIUM EFFECT */

.bank-page-animate{

    animation:pageReveal .75s cubic-bezier(.22,1,.36,1);

    transform-origin:top center;
}

/* =========================
    TABLE POPUP EFFECT
========================= */

@keyframes popupRow{

    0%{
        opacity:0;
        transform:perspective(1000px) rotateX(-12deg) translateY(18px);
    }

    100%{
        opacity:1;
        transform:perspective(1000px) rotateX(0deg) translateY(0);
    }
}

/* =========================
    TABLE ROW ANIMATION
========================= */

.table-row{

    position: relative;

    opacity: 0;

    transform: translateY(18px) scale(.98);

    animation: rowReveal .65s cubic-bezier(.22,1,.36,1) forwards;

    will-change: transform, opacity;

    transition:
        transform .25s ease,
        box-shadow .25s ease,
        background-color .25s ease;
}

@keyframes rowReveal{

    0%{
        opacity:0;
        transform:translateY(22px) scale(.96);
    }

    60%{
        opacity:1;
        transform:translateY(-2px) scale(1.01);
    }

    100%{
        opacity:1;
        transform:translateY(0) scale(1);
    }
}

/* PREMIUM HOVER */

.table-row:hover{

    transform:translateY(-3px) scale(1.004);

    box-shadow:
        0 10px 24px rgba(15,23,42,.08),
        0 4px 10px rgba(59,130,246,.08);

    background:#fcfdff;
}

/* =========================
    TABLE WRAPPER GLASS EFFECT
========================= */

.table-premium{

    position:relative;

    overflow:hidden;

    border-radius:24px;

    background:
        linear-gradient(
            180deg,
            rgba(255,255,255,.95),
            rgba(248,250,252,.96)
        );

    border:1px solid rgba(226,232,240,.9);

    box-shadow:
        0 10px 30px rgba(15,23,42,.06),
        inset 0 1px 0 rgba(255,255,255,.7);
}

/* TOP SHINE EFFECT */

.table-premium::before{

    content:"";

    position:absolute;

    top:0;
    left:-120%;

    width:60%;
    height:100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.45),
            transparent
        );

    transform:skewX(-25deg);

    animation:shineMove 4.5s infinite;
}

@keyframes shineMove{

    100%{
        left:150%;
    }
}

/* =========================
    HEADER ANIMATION
========================= */

thead tr{

    animation:headerDrop .5s ease;
}

@keyframes headerDrop{

    from{
        opacity:0;
        transform:translateY(-10px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* =========================
    MOBILE OPTIMIZATION
========================= */

@media(max-width:768px){

    .bank-page-animate{
        animation-duration:.55s;
    }

    .table-row:hover{
        transform:none;
    }

    .table-premium{

        width:100%;

        overflow-x:auto;

        -webkit-overflow-scrolling:touch;
    }

}

/* TABLE RESPONSIVE FIX */

.table-premium{

    overflow-x:auto;
}

/* ROW CARD EFFECT */

tbody tr{

    border-radius:18px;

    overflow:hidden;
}

/* MOBILE FIX */

@media(max-width:768px){

    .table-row{

        min-width:100%;
    }

}

/* =========================
    STATUS TOGGLE
========================= */

.slider-toggle + div{

    width:52px;
    height:28px;

    background:#e5e7eb;

    border-radius:999px;

    position:relative;

    transition:.3s ease;
}

.slider-toggle + div .dot{

    position:absolute;

    top:4px;
    left:4px;

    width:20px;
    height:20px;

    background:#fff;

    border-radius:50%;

    transition:.3s ease;

    box-shadow:0 2px 6px rgba(0,0,0,.15);
}

.slider-toggle:checked + div{

    background:linear-gradient(135deg,#22c55e,#16a34a);
}

.slider-toggle:checked + div .dot{

    transform:translateX(24px);
}
/* ACTION GROUP */

.action-group{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:10px;

    flex-wrap:nowrap;
}

/* MOBILE */

@media(max-width:768px){

    .action-group{

        flex-direction:row;

        flex-wrap:nowrap;

        gap:6px;
    }

    .action-btn{

        width:auto !important;

        min-width:70px;
    }
}
</style>