

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
            0%, 100% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(0.6);
                opacity: 0.5;
            }
        }

        .hidden {
            display: none;
        }

    </style>

    <!-- Dot Pulse -->
    <div class="hidden" id="main_loader">
        <div class="dot-pulse" style=" position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #121212; display: flex; justify-content: center; align-items: center; z-index: 9999;">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
   


