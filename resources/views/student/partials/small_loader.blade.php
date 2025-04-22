<style>
    /* Dot Pulse */
    .dot-pulse {
        display: flex;
        gap: 8px;
    }

    .dot-pulse div {
        width: 12px;
        height: 12px;
        background-color: #80CBC4;
        border-radius: 50%;
        animation: pulse 1.2s ease-in-out infinite;
    }

    .dot-pulse div:nth-child(2) {
        animation-delay: 0.2s;
    }

    .dot-pulse div:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(0.6);
            opacity: 0.5;
        }
    }



    .load {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>
</head>

<body>


    <!-- Dot Pulse -->
    <div id="loader" class="dot-pulse load">
        <div></div>
        <div></div>
        <div></div>
    </div>


</body>