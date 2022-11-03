<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="bg-auth flex min-h-screen flex-col items-center justify-center bg-charleston-green bg-center bg-no-repeat">
    <div class="flex flex-col items-center rounded-xl px-22 py-15 shadow">
        <div class="mb-4">
            <div class="font-circular-std text-5xl text-white">
                Indy<span class="text-halloween-orange">.</span>
            </div>
        </div>
        <div class="mb-2 text-2.5xl font-semibold text-halloween-orange empty:hidden">
            Coming Soon
        </div>
    </div>
</div>
</body>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const slider = document.querySelector('#slider');
        setTimeout(function moveSlide() {
            const max = slider.scrollWidth - slider.clientWidth;
            const left = slider.clientWidth;

            if (max === slider.scrollLeft) {
                slider.scrollTo({left: 0, behavior: 'smooth'})
            } else {
                slider.scrollBy({left, behavior: 'smooth'})
            }

            setTimeout(moveSlide, 2000)
        }, 2000)

    })
</script>
</body>
</html>
