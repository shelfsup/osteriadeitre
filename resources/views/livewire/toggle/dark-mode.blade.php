<label for="toggle" id="toggle-label">
    <style>
        .toggle {
            display: none;
        }

        .toggle-label {
            cursor: pointer;
            outline: transparent;
        }

        .toggle-div {
            height: 40px;
            width: 80px;
            background-color: #357bb3;
            border-radius: 100px;
            position: relative;
            overflow: hidden;
            transition: all 300ms ease;
            box-shadow: inset 2px 5px 5px rgba(0, 0, 0, 0.8),
                inset -2px -5px 5px rgba(0, 0, 0, 0.2), 1px 1px 1px rgba(255, 255, 255, 1);
        }

        .backdrops {
            position: absolute;
            left: 10px;
            top: 10px;
            height: 20px;
            width: 20px;
            transition: all 300ms ease;
        }

        .backdrop {
            height: 100px;
            width: 100px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 100%;
            position: absolute;
            left: 30%;
            top: 50%;
            transform: translate(-50%, -50%);
            transition: all 300ms ease;
        }

        .backdrop::after,
        .backdrop::before {
            content: "";
            height: 100px;
            width: 100px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 100%;
            position: absolute;
            transition: all 300ms ease;
        }

        .backdrop::before {
            left: 15%;
        }

        .backdrop::after {
            left: 30%;
        }

        .clouds {
            position: absolute;
            height: 100%;
            width: 100%;
            top: 50%;
            left: 0;
            transform: translate(0, -50%);
            transition: all 300ms ease;
        }

        .cloud {
            position: absolute;
            right: 10%;
            top: 50%;
            background-color: #fbfbfb;
            height: 9px;
            width: 28px;
            border-radius: 0 100px 100px 100px;
            transform: scale(-0.8, 0.8);
        }

        .cloud::before {
            content: "";
            position: absolute;
            background-color: #fbfbfb;
            height: 7px;
            width: 22px;
            bottom: 8px;
            left: 0px;
            border-radius: 100px 100px 0 0px;
        }

        .cloud::after {
            content: "";
            position: absolute;
            background-color: #fbfbfb;
            height: 12px;
            width: 12px;
            bottom: 7px;
            left: 1px;
            border-radius: 100%;
        }

        .cloud-1 {
            top: 51%;
            right: 24%;
            transform: scale(-0.6, 0.6);
            opacity: 0.5;
        }

        .cloud-2 {
            top: 22%;
            right: -1%;
            transform: scale(-0.5, 0.6);
            opacity: 0.5;
        }

        .cloud-3 {
            top: 92%;
            right: 35%;
        }

        .cloud-4 {
            top: 79%;
            right: -5%;
            transform: scale(-1, 1);
        }

        .cloud-5 {
            top: 93%;
            right: 18%;
            transform: rotateZ(-10deg) scale(-1, 1);
        }

        .sun-moon {
            height: 35px;
            width: 35px;
            background-color: #f1c428;
            border-radius: 100%;
            box-shadow: inset 2px 5px 3px rgba(255, 255, 255, 0.5),
                inset -2px -5px 3px rgba(0, 0, 0, 0.5), 5px 5px 10px rgba(0, 0, 0, 0.5);
            position: absolute;
            left: 3px;
            top: 2px;
            transition: 300ms ease;
        }

        /* .sun-moon:hover {
          left: 15px;
        } */

        /* NIGHT */

        .stars {
            position: absolute;
            height: 100%;
            width: 100%;
            top: -50%;
            left: 0;
            transform: translate(0, -50%);
            transition: all 300ms ease;
        }

        .star {
            position: absolute;
            left: 10%;
            top: 50%;
            height: 6px;
            width: 6px;
            border-radius: 100%;
            background-color: #c4c9d2;
            box-shadow: 0 0 4px #fff;
            animation: twinkle 1s infinite alternate;
        }

        .star::before {
            content: "";
            position: absolute;
            left: 300%;
            top: 300%;
            height: 4px;
            width: 4px;
            border-radius: 100%;
            background-color: #c4c9d2;
            box-shadow: 0 0 4px #fff;
        }

        .star::after {
            content: "";
            position: absolute;
            left: 400%;
            bottom: 400%;
            height: 5px;
            width: 5px;
            border-radius: 100%;
            background-color: #c4c9d2;
            box-shadow: 0 0 4px #fff;
        }

        .star-2 {
            left: 40%;
            top: 10%;
            transform: rotateZ(75deg) scale(1.1);
            animation-delay: 300ms;
        }

        .star-3 {
            left: 40%;
            top: 60%;
            transform: rotateZ(150deg) scale(0.8);
            animation-delay: 600ms;
        }

        .crater {
            display: none;
            position: absolute;
            left: 25%;
            top: 60%;
            transform: translate(-50%, -50%);
            height: 6px;
            width: 6px;
            background-color: #949eb2;
            border-radius: 100%;
            box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.4);
        }

        .crater::before {
            content: "";
            height: 5px;
            width: 5px;
            position: absolute;
            top: -180%;
            left: 50%;
            background-color: #949eb2;
            border-radius: 100%;
            box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.4);
        }

        .crater::after {
            content: "";
            height: 10px;
            width: 10px;
            position: absolute;
            bottom: 60%;
            left: 190%;
            background-color: #949eb2;
            border-radius: 100%;
            box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.4);
        }

        .toggle-div.night {
            background-color: #1d1f2b;
        }

        input:checked~.clouds {
            top: 150%;
        }

        input:checked~.sun-moon {
            left: calc(100% - 38px);
            background-color: #c4c9d2;
            transform: rotateZ(180deg);
        }

        /* input:checked ~ .sun-moon:hover {
          left: calc(100% - 115px);
        }
         */
        input:checked~.backdrops {
            left: calc(100% - 14px);
        }

        input:checked~.sun-moon .crater {
            display: block;
        }

        input:checked~.stars {
            top: 50%;
        }

        /* ANIMATIONS */

        @keyframes twinkle {
            from {
                opacity: 1;
            }

            to {
                opacity: 0.5;
            }
        }
    </style>


    <div id="toggle-div" class="toggle-div">
        <input type="checkbox" id="toggle" class="toggle" />
        <div class="clouds">
            <div class="cloud cloud-1"></div>
            <div class="cloud cloud-2"></div>
            <div class="cloud cloud-3"></div>
            <div class="cloud cloud-4"></div>
            <div class="cloud cloud-5"></div>
        </div>
        <div class="backdrops">
            <div class="backdrop"></div>
        </div>
        <div class="stars">
            <div class="star star-1"></div>
            <div class="star star-2"></div>
            <div class="star star-3"></div>
        </div>
        <div class="sun-moon">
            <div class="crater"></div>
        </div>
    </div>
</label>

@push('scripts')
    <script>
        const storageKey = "theme-preference";

        const onClick = () => {
            // flip current value
            theme.value = theme.value === "light" ? "dark" : "light";

            setPreference();
        };

        const getColorPreference = () => {
            if (localStorage.getItem(storageKey))
                return localStorage.getItem(storageKey);
            else
                return window.matchMedia("(prefers-color-scheme: dark)").matches ?
                    "dark" :
                    "light";
        };

        const setPreference = () => {
            localStorage.setItem(storageKey, theme.value);
            reflectPreference();
        };

        const reflectPreference = () => {
            document.firstElementChild.setAttribute("data-theme", theme.value);

            // Riflette lo stato del toggle
            document.querySelectorAll(".toggle").forEach(toggle => {
                toggle.checked = theme.value === "dark";
            });

            document.querySelectorAll(".toggle-div").forEach(div => {
                div.classList.toggle("night", theme.value === "dark");
            });

            // Mostra il body dopo aver impostato il tema
            document.body.style.display = 'block';
        };

        const theme = {
            value: getColorPreference(),
        };

        // Imposta il tema all'avvio
        reflectPreference();

        window.onload = () => {
            // Imposta il tema all'avvio
            reflectPreference();

            // Gestisce il cambiamento del tema
            document.querySelectorAll(".toggle").forEach(toggle => {
                toggle.addEventListener("change", onClick);
            });
        };

        // Sincronizza con i cambiamenti del sistema
        window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", ({
            matches: isDark
        }) => {
            theme.value = isDark ? "dark" : "light";
            setPreference();
        });

        // Funzione per invertire il tema manualmente
        function toggleTheme() {
            document.querySelectorAll(".toggle").forEach(toggle => {
                toggle.checked = !toggle.checked;
                toggle.dispatchEvent(new Event("change"));
            });
        }
    </script>
@endpush
