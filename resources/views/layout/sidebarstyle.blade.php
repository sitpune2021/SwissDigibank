<style>
.submenu {
    margin: 0;
    padding: 0;
    list-style: none;
}

/* hidden state */
.submenu{
    display:none;
    margin-top:6px;
}

.submenu.submenu-show{
    display:block !important;
}
</style>

<style>
.menu-ul li:last-child {
    margin-bottom: 20px;
}
.menu-container {
    scroll-behavior: smooth;
}
    /* 🔥 HOVER EFFECT */
.menu-btn:hover{

    background:
    linear-gradient(
        135deg,
        rgba(59,130,246,0.22),
        rgba(6,182,212,0.14)
    ) !important;

    transform:
        translateX(5px)
        scale(1.01);

    border-color:
        rgba(96,165,250,0.22);

    box-shadow:
        0 10px 35px rgba(37,99,235,0.18),
        0 0 18px rgba(59,130,246,0.15);

    color:#fff !important;
}
/* =========================================
   NEO MENU TEXT
========================================= */

.neo-menu-text{

    color:#f8fafc !important;

    font-weight:600;

    letter-spacing:0.4px;

    text-shadow:
        0 0 8px rgba(255,255,255,0.15),
        0 0 16px rgba(59,130,246,0.12);

    transition:all .28s ease;
}

/* HOVER */
.menu-btn:hover .neo-menu-text{

    color:#ffffff !important;

    text-shadow:
        0 0 10px rgba(255,255,255,0.35),
        0 0 22px rgba(59,130,246,0.28);
}

/* ACTIVE */
.menu-btn.active .neo-menu-text{

    color:#ffffff !important;

    text-shadow:
        0 0 12px rgba(255,255,255,0.45),
        0 0 28px rgba(96,165,250,0.45);
}
/* 🔥 ACTIVE MENU */
.menu-btn.active{

    background:
    linear-gradient(
        90deg,
        #33697e,
        #33697e
    ) !important;

    color:#fff !important;

    border-color:transparent;

    box-shadow:
        0 10px 25px rgba(37,99,235,0.25);
}

/* 🔥 LEFT ACTIVE LINE */
.menu-li.active::before{
    content:"";
    position:absolute;

    left:-10px;
    top:10%;

    width:4px;
    height:80%;

    border-radius:20px;

    background:
    linear-gradient(
    180deg,
    #60a5fa,
    #22d3ee
    );

    box-shadow:
    0 0 14px rgba(59,130,246,0.8);
}

.menu-icon{

    width:36px;
    height:36px;

    border-radius:14px;

    display:flex;
    align-items:center;
    justify-content:center;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.08),
            rgba(255,255,255,0.03)
        );

    border:1px solid rgba(255,255,255,0.08);

    transition:.3s;

    color:#bfdbfe;

    backdrop-filter: blur(10px);

    box-shadow:
        0 6px 14px rgba(0,0,0,0.22),
        inset 0 1px 0 rgba(255,255,255,0.06);
}

.menu-btn:hover .menu-icon,
.menu-btn.active .menu-icon{

    background:rgba(255,255,255,0.12);

    transform:scale(1.06);

    box-shadow:0 0 15px rgba(255,255,255,0.08);
}

/* 🔥 SUBMENU STYLE */
.submenu-link{

    display:flex;
    align-items:center;
    gap:10px;

    color:#cbd5e1;

    padding:10px 14px !important;

    margin:4px 0;

    border-radius:12px;

    transition:all .25s ease;
}

/* 🔥 SUBMENU HOVER */
.submenu-link:hover{

    color:#fff;

    background:
    linear-gradient(
    90deg,
    rgba(59,130,246,0.15),
    rgba(6,182,212,0.08)
    );

    transform:translateX(4px);
}
.menu-ul{
    display:flex;
    flex-direction:column;
    gap:8px;
}

.menu-container::-webkit-scrollbar{
    width:6px;
}

.menu-container::-webkit-scrollbar-track{
    background:transparent;
}

.menu-container::-webkit-scrollbar-thumb{
    background:rgba(148,163,184,0.25);
    border-radius:20px;
}

.menu-container::-webkit-scrollbar-thumb:hover{
    background:rgba(59,130,246,0.5);
}

/* 🔥 ICON GLOW */
.menu-btn:hover i {
    text-shadow: 0 0 8px #3b82f6;
}
.menu-btn{

    position:relative;
    width:100%;

    padding:12px 14px !important;

    border-radius:18px !important;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.02)
        ) !important;

    border:1px solid rgba(255,255,255,0.08);

    transition:all .32s ease;

    overflow:hidden;

    backdrop-filter: blur(16px);

    box-shadow:
        0 8px 20px rgba(0,0,0,0.28),
        inset 0 1px 0 rgba(255,255,255,0.05);
}
.menu-li {
    background: transparent !important;
}

.menu-li * {
    background-color: transparent !important;
}

/* =======================================================
   RESPONSIVE SIDEBAR
======================================================= */

/* =======================================================
   DESKTOP SIDEBAR
======================================================= */

.sidebar{
    width:270px;
    min-width:270px;
    height:100vh;

    position:fixed;
    top:0;
    left:0;

    z-index:9999;

    overflow-y:auto;
    overflow-x:hidden;

    transform: translateX(0);
    transition: transform .3s ease;
}

/* HIDE STATE */
.sidebar.hide-sidebar{
    transform: translateX(-100%);
}

/* CONTENT */
.main-content{
    margin-left:270px;
    width: calc(100% - 270px);
    transition: all .3s ease;
}

.main-content.full{
    margin-left:0 !important;
    width:100% !important;
}

/* MOBILE OVERLAY */
.sidebar-overlay{
    position:fixed;
    inset:0;

    background:rgba(0,0,0,0.6);

     z-index:99990;

    opacity:0;
    visibility:hidden;

    transition:.3s;
}

.sidebar-overlay.show{
    opacity:1;
    visibility:visible;
}

/* MOBILE VIEW */
@media(max-width:991px){

    .sidebar{
        position: fixed !important;
        top: 0;
        left: 0;
        width: 270px;
        height: 100vh;

        transform: translateX(-100%);
        transition: transform .3s ease-in-out !important;

        z-index: 99999 !important;
    }

    .sidebar.show{
        transform: translateX(0%) !important;
    }

    .main-content{
        margin-left:0 !important;
        width:100%;
    }
}

/* SMALL MOBILE */
@media(max-width:576px){

    .sidebar{
        width:85%;
        min-width:85%;
    }
    .sidebar.show{
    transform: translateX(0) !important;
}

    .menu-btn{
        border-radius:12px !important;
    }

    .submenu-link{
        padding:8px 10px !important;
    }
}
.submenu{

    margin-top:10px;

    padding:10px;

    border-radius:18px;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,0.05),
            rgba(255,255,255,0.02)
        );

    backdrop-filter: blur(18px);

    border:
        1px solid rgba(255,255,255,0.06);

    box-shadow:
        0 10px 30px rgba(0,0,0,0.22);
}
/* =========================================
   PREMIUM ANIMATED NEO SIDEBAR
========================================= */

.neo-sidebar{

    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            180deg,
            #040404 0%,
            #1b1b1d 35%,
            #2c3440 100%
        );

    border-right:1px solid rgba(255,255,255,0.08);

    box-shadow:
        0 0 40px rgba(0,0,0,0.55),
        inset 0 1px 0 rgba(255,255,255,0.04);

    backdrop-filter: blur(20px);
}

/* =========================================
   MOVING GRADIENT LIGHT
========================================= */

.neo-sidebar::before{

    content:"";

    position:absolute;

    width:420px;
    height:420px;

    top:-120px;
    left:-140px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(59,130,246,0.18),
            transparent 70%
        );

    animation:
        floatingGlow 10s ease-in-out infinite;

    pointer-events:none;
}

/* SECOND LIGHT */

.neo-sidebar::after{

    content:"";

    position:absolute;

    width:360px;
    height:360px;

    bottom:-120px;
    right:-100px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(168,85,247,0.16),
            transparent 70%
        );

    animation:
        floatingGlow2 12s ease-in-out infinite;

    pointer-events:none;
}

/* =========================================
   FLOAT ANIMATION
========================================= */

@keyframes floatingGlow{

    0%{
        transform:
            translate(0px,0px)
            scale(1);
    }

    50%{
        transform:
            translate(40px,30px)
            scale(1.1);
    }

    100%{
        transform:
            translate(0px,0px)
            scale(1);
    }
}

@keyframes floatingGlow2{

    0%{
        transform:
            translate(0px,0px)
            scale(1);
    }

    50%{
        transform:
            translate(-30px,-40px)
            scale(1.08);
    }

    100%{
        transform:
            translate(0px,0px)
            scale(1);
    }
}

/* =========================================
   SHINING TOP LIGHT
========================================= */

.logo-container::before{

    content:"";

    position:absolute;

    top:0;
    left:-100%;

    width:120%;
    height:2px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,0.7),
            transparent
        );

    animation:
        shineMove 4s linear infinite;
}

    @keyframes shineMove{

        0%{
            left:-100%;
        }

        100%{
            left:120%;
        }
    }
.menu-btn::before{

    content:"";

    position:absolute;

    inset:0;

    background:
        linear-gradient(
            120deg,
            transparent,
            rgba(255,255,255,0.08),
            transparent
        );

    transform:translateX(-100%);

    transition:0.6s;
}

.menu-btn:hover::before{
    transform:translateX(100%);
}
/* =========================================
   RIGHT SIDE VERTICAL ANIMATION
========================================= */

.neo-sidebar .sidebar-right-glow{

    position:absolute;

    top:0;
    right:0;

    width:3px;
    height:100%;

    overflow:hidden;

    z-index:2;
}

.neo-sidebar .sidebar-right-glow::before{

    content:"";

    position:absolute;

    top:-30%;

    right:0;

    width:100%;
    height:220px;

    border-radius:50px;

    background:
        linear-gradient(
            180deg,
            transparent,
            #60a5fa,
            #22d3ee,
            transparent
        );

    box-shadow:
        0 0 25px #3b82f6,
        0 0 40px #06b6d4;

    animation:
        verticalLightMove 5s linear infinite;
}

/* =========================================
   TOP HORIZONTAL ANIMATION
========================================= */

.neo-sidebar .sidebar-top-glow{

    position:absolute;

    top:0;
    left:0;

    width:100%;
    height:3px;

    overflow:hidden;

    z-index:2;
}

.neo-sidebar .sidebar-top-glow::before{

    content:"";

    position:absolute;

    left:-30%;

    top:0;

    width:220px;
    height:100%;

    border-radius:50px;

    background:
        linear-gradient(
            90deg,
            transparent,
            #818cf8,
            #38bdf8,
            transparent
        );

    box-shadow:
        0 0 25px #6366f1,
        0 0 40px #38bdf8;

    animation:
        horizontalLightMove 4s linear infinite;
}

/* =========================================
   ANIMATION KEYFRAMES
========================================= */

@keyframes verticalLightMove{

    0%{
        top:-30%;
    }

    100%{
        top:120%;
    }
}

@keyframes horizontalLightMove{

    0%{
        left:-30%;
    }

    100%{
        left:120%;
    }
}
/* ===================================================
   ULTRA PREMIUM NEO SIDEBAR EFFECT
=================================================== */

.neo-sidebar{

    position:relative;

    overflow:hidden;

    isolation:isolate;

    background:
        linear-gradient(
            180deg,
            #050816 0%,
            #0f172a 40%,
            #111827 100%
        );

    border-right:
        1px solid rgba(255,255,255,0.08);

    backdrop-filter: blur(20px);

    animation:
        breathingSidebar 6s ease-in-out infinite;
}

/* ===================================================
   AURORA GRADIENT
=================================================== */

.neo-sidebar::before{

    content:"";

    position:absolute;

    inset:-40%;

    background:
        conic-gradient(
            from 180deg,
            rgba(59,130,246,0.18),
            rgba(168,85,247,0.18),
            rgba(6,182,212,0.16),
            rgba(59,130,246,0.18)
        );

    filter: blur(80px);

    animation:
        auroraMove 18s linear infinite;

    z-index:-2;
}

/* ===================================================
   RGB BORDER ANIMATION
=================================================== */

.neo-sidebar::after{

    content:"";

    position:absolute;

    inset:0;

    padding:1px;

    border-radius:0;

    background:
        linear-gradient(
            180deg,
            #3b82f6,
            #8b5cf6,
            #06b6d4,
            #3b82f6
        );

    background-size:400% 400%;

    animation:
        rgbBorder 8s linear infinite;

    -webkit-mask:
        linear-gradient(#fff 0 0) content-box,
        linear-gradient(#fff 0 0);

    -webkit-mask-composite:xor;

    mask-composite:exclude;

    pointer-events:none;

    opacity:.8;
}

/* ===================================================
   PARTICLES
=================================================== */

.neo-particles span{

    position:absolute;

    display:block;

    width:4px;
    height:4px;

    border-radius:50%;

    background:rgba(255,255,255,0.8);

    box-shadow:
        0 0 10px rgba(59,130,246,0.8),
        0 0 20px rgba(6,182,212,0.5);

    animation:
        particleMove linear infinite;
}

/* RANDOM PARTICLES */

.neo-particles span:nth-child(1){
    left:10%;
    animation-duration:10s;
    animation-delay:0s;
}

.neo-particles span:nth-child(2){
    left:25%;
    animation-duration:14s;
    animation-delay:2s;
}

.neo-particles span:nth-child(3){
    left:40%;
    animation-duration:12s;
    animation-delay:1s;
}

.neo-particles span:nth-child(4){
    left:60%;
    animation-duration:16s;
    animation-delay:4s;
}

.neo-particles span:nth-child(5){
    left:80%;
    animation-duration:13s;
    animation-delay:2s;
}

/* ===================================================
   MOUSE LIVE GLOW
=================================================== */

.mouse-glow{

    position:absolute;

    width:240px;
    height:240px;

    border-radius:50%;

    background:
        radial-gradient(
            circle,
            rgba(59,130,246,0.18),
            transparent 70%
        );

    pointer-events:none;

    transform:translate(-50%,-50%);

    mix-blend-mode:screen;

    z-index:1;
}

/* ===================================================
   BREATHING EFFECT
=================================================== */

@keyframes breathingSidebar{

    0%,100%{
        box-shadow:
            0 0 25px rgba(59,130,246,0.12),
            inset 0 0 12px rgba(255,255,255,0.03);
    }

    50%{
        box-shadow:
            0 0 40px rgba(168,85,247,0.18),
            inset 0 0 18px rgba(255,255,255,0.05);
    }
}

/* ===================================================
   RGB BORDER
=================================================== */

@keyframes rgbBorder{

    0%{
        background-position:0% 50%;
    }

    100%{
        background-position:400% 50%;
    }
}

/* ===================================================
   AURORA ANIMATION
=================================================== */

@keyframes auroraMove{

    0%{
        transform:
            rotate(0deg)
            scale(1);
    }

    50%{
        transform:
            rotate(180deg)
            scale(1.15);
    }

    100%{
        transform:
            rotate(360deg)
            scale(1);
    }
}

/* ===================================================
   PARTICLES MOVE
=================================================== */

@keyframes particleMove{

    0%{
        transform:
            translateY(100vh)
            scale(0);

        opacity:0;
    }

    10%{
        opacity:1;
    }

    100%{
        transform:
            translateY(-120px)
            scale(1.5);

        opacity:0;
    }
}
</style>

<script>

const sidebar = document.getElementById("sidebar");
const glow = document.getElementById("mouseGlow");

sidebar.addEventListener("mousemove", (e) => {

    const rect = sidebar.getBoundingClientRect();

    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    glow.style.left = `${x}px`;
    glow.style.top = `${y}px`;

});

</script>