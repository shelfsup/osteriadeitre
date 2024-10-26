<div>
    <style>

        @keyframes animate {

            0%,
            100% {
                transform: translateY(20px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .clock {
            position: relative;
            height: fit-content;
            /* background: var(--bg-White);
            box-shadow: var(--shadow-3); */
            border-radius: 18px;
        }

        .clock .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .clock .container h2 {
            font-size: 2em;
            color: var(--color-text);
        }

        .clock .container h2:nth-child(odd) {
            padding: 5px 15px;
            border-radius: 10px;
            background: var(--bg-lightgreen3);
            box-shadow: var(--box-shadow-3);
            /* margin: 3rem 10px; */
            margin: 0 10px;
        }

        .clock .container h2#seconds {
            color: var(--color-text-seconds);
        }

        #ampm {
            position: relative;
            top: -2rem;
            font-size: 1.5em;
            color: var(--color-text);
            font-weight: 700;
        }
    </style>
    <section>
        <div class="clock">
            <div class="container">
                <h2 id="hour">00</h2>
                <h2 class="dot m-0">:</h2>
                <h2 id="minute">09</h2>
                <h2 class="dot m-0">:</h2>
                <h2 id="seconds">24</h2>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        function clock() {
            let hours = document.getElementById('hour');
            let minute = document.getElementById('minute');
            let seconds = document.getElementById('seconds');

            let h = new Date().getHours();
            let m = new Date().getMinutes();
            let s = new Date().getSeconds();

            // Add 0 to beginning if less than 10
            h = (h < 10) ? '0' + h : h;
            m = (m < 10) ? '0' + m : m;
            s = (s < 10) ? '0' + s : s;

            hours.innerHTML = h;
            minute.innerHTML = m;
            seconds.innerHTML = s;
        }
        var interval = setInterval(clock, 1000);
    </script>
@endpush

