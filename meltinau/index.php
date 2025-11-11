<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Slideshow Foto PHP</title>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;500&display=swap');

    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lora:wght@400;500&family=Dancing+Script:wght@400;700&family=Poppins:wght@300;400;600&display=swap');

    /* Feminine / soft-pastel theme */
    body {
        background: radial-gradient(1200px 600px at 10% 10%, rgba(255, 230, 240, 0.45), transparent 10%),
                    radial-gradient(1000px 500px at 90% 90%, rgba(255, 245, 230, 0.45), transparent 10%),
                    linear-gradient(135deg, #fff1f6 0%, #ffeef1 30%, #fffaf5 100%);
        background-attachment: fixed;
        font-family: 'Poppins', 'Lora', serif;
        text-align: center;
        color: #5a4350;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* soft texture overlay (subtle dots/bokeh) */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: radial-gradient(rgba(255,255,255,0.15) 1px, transparent 1px);
        background-size: 24px 24px;
        opacity: 0.25;
        pointer-events: none;
        z-index: 0;
    }

    /* Decorative floral accent top-left */
    body::after {
        content: '';
        position: fixed;
        top: -60px;
        left: -60px;
        width: 260px;
        height: 260px;
        background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="260" height="260"><g fill="%23F8D0E0"><circle cx="40" cy="40" r="28"/><circle cx="80" cy="70" r="24"/></g><g fill="%23FCEDEE"><circle cx="140" cy="40" r="32"/><circle cx="100" cy="100" r="18"/></g></svg>');
        opacity: 0.45;
        pointer-events: none;
        z-index: 0;
    }

    h1 {
        margin-top: 50px;
        font-family: 'Dancing Script', 'Playfair Display', serif;
        color: #7b4a5a;
        font-size: 46px;
        font-weight: 700;
        letter-spacing: 1px;
        text-shadow: 0 2px 6px rgba(150,100,120,0.08);
        position: relative;
        z-index: 2;
    }

    .subtitle {
        font-size: 16px;
        color: #9b6f7f;
        margin-top: 8px;
        font-style: italic;
        letter-spacing: 0.5px;
        font-family: 'Poppins', sans-serif;
    }

    .btn {
        padding: 12px 34px;
        background: linear-gradient(180deg, #ffd6e6 0%, #ffb3d0 100%);
        color: #6b394a;
        border: none;
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 600;
        border-radius: 28px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 22px;
        box-shadow: 0 10px 20px rgba(183,120,150,0.15);
        text-transform: none;
        letter-spacing: 0.4px;
        position: relative;
        z-index: 2;
    }

    .btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 30px rgba(183,120,150,0.18);
    }

    .btn:active {
        transform: translateY(-2px);
    }

    h1 {
        margin-top: 50px;
        font-family: 'Playfair Display', serif;
        color: #5d4e37;
        font-size: 48px;
        font-weight: 700;
        letter-spacing: 2px;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 36px;
            margin-top: 30px;
        }
    }

    @media (max-width: 480px) {
        h1 {
            font-size: 28px;
            margin-top: 20px;
            letter-spacing: 1px;
        }
    }

    .subtitle {
        font-size: 16px;
        color: #8B6F47;
        margin-top: 10px;
        font-style: italic;
        letter-spacing: 1px;
    }

    .btn {
        padding: 14px 40px;
        background: linear-gradient(135deg, #C4A57B 0%, #D4AF85 100%);
        color: #5d4e37;
        border: 2px solid #8B6F47;
        font-family: 'Playfair Display', serif;
        font-size: 18px;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.4s ease;
        margin-top: 30px;
        box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        z-index: 2;
    }

    .btn:hover {
        background: linear-gradient(135deg, #D4AF85 0%, #C4A57B 100%);
        transform: translateY(-3px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.3);
    }

    .btn:active {
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .btn {
            padding: 12px 30px;
            font-size: 16px;
            margin-top: 20px;
        }
    }

    @media (max-width: 480px) {
        .btn {
            padding: 10px 25px;
            font-size: 14px;
            margin-top: 15px;
        }
    }

    .slideshow-wrapper {
        position: relative;
        z-index: 2;
        margin-top: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 0;
    }

    .slideshow-wrapper.active {
        min-height: 430px;
    }

    .slideshow-container {
        display: none;
        position: relative;
        margin: 0;
        width: 90vw;
        max-width: 520px;
        height: 60vw;
        max-height: 380px;
        background: #f5f1e8;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 
            0 10px 40px rgba(0,0,0,0.4),
            -5px -5px 15px rgba(255,255,255,0.2),
            5px 15px 30px rgba(0,0,0,0.3);
        transform: perspective(1000px) rotateX(2deg) rotateZ(-1deg);
        animation: polaroidAppear 0.8s ease-out;
    }

    .slideshow-container.active {
        display: block;
    }

    /* Responsive untuk Tablet */
    @media (max-width: 768px) {
        .slideshow-container {
            width: 85vw;
            max-width: 450px;
            height: 55vw;
            max-height: 320px;
            padding: 20px;
        }

        .slideshow-wrapper.active {
            min-height: 380px;
        }
    }

    /* Responsive untuk Mobile */
    @media (max-width: 480px) {
        .slideshow-container {
            width: 90vw;
            max-width: 100%;
            height: 65vw;
            max-height: 100%;
            padding: 15px;
        }

        .slideshow-wrapper.active {
            min-height: 350px;
        }

        .text-overlay {
            font-size: 14px;
            padding: 12px 20px;
            bottom: 20px;
        }
    }

    @keyframes polaroidAppear {
        from {
            opacity: 0;
            transform: scale(0.8) rotate(-5deg);
        }
        to {
            opacity: 1;
            transform: perspective(1000px) rotateX(2deg) rotateZ(-1deg);
        }
    }

    .slideshow-inner {
        position: relative;
        width: 100%;
        height: 100%;
        overflow: hidden;
        border-radius: 4px;
    }

    .slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 2.5s ease-in-out;
    }

    .slide.active {
        opacity: 1;
    }

    .slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        filter: sepia(0.2) contrast(1.05);
    }

    .text-overlay {
        position: absolute;
        bottom: 30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(93, 78, 55, 0.85);
        padding: 15px 25px;
        border-radius: 4px;
        font-size: 18px;
        font-weight: 500;
        color: #fff;
        text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        font-family: 'Lora', serif;
        font-style: italic;
        max-width: 90%;
        text-align: center;
        letter-spacing: 0.5px;
    }

    .slide-counter {
        position: absolute;
        top: 15px;
        right: 20px;
        font-size: 14px;
        color: rgba(93, 78, 55, 0.7);
        font-family: 'Playfair Display', serif;
        z-index: 10;
    }

    .decorative-dots {
        text-align: center;
        margin-top: 40px;
        position: relative;
        z-index: 2;
    }

    .dot {
        height: 12px;
        width: 12px;
        margin: 0 8px;
        background-color: rgba(93, 78, 55, 0.4);
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .dot.active {
        background-color: #8B6F47;
        transform: scale(1.3);
        border-color: #C4A57B;
    }

    .dot:hover {
        background-color: #C4A57B;
    }

    .controls {
        margin-top: 30px;
        position: relative;
        z-index: 2;
        display: none;
    }

    .controls.show {
        display: block;
    }

    .control-btn {
        background: #C4A57B;
        color: #5d4e37;
        border: none;
        padding: 10px 20px;
        margin: 0 10px;
        border-radius: 6px;
        cursor: pointer;
        font-family: 'Playfair Display', serif;
        font-weight: bold;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
    }

    .control-btn:hover {
        background: #D4AF85;
        transform: translateY(-2px);
    }

    .footer-text {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: rgba(93, 78, 55, 0.6);
        font-size: 12px;
        font-style: italic;
        z-index: 1;
    }
</style>
</head>
<body>

<h1>Selamat Ulang Tahun Meltin</h1>

<button class="btn" id="startBtn">Iya Dito</button>

<div class="slideshow-wrapper" id="wrapper">
    <div class="slideshow-container" id="slideshow">
        <?php
        // Daftar gambar dan teksnya (10 foto)
        $gambar = [
            ["file" => "foto1.jpg", "teks" => "Selamat Ulang Tahun Ya. Meltin"],
            ["file" => "foto2.jpg", "teks" => "Terima kasih sekali udah menemani hari-hariku"],
            ["file" => "foto3.jpg", "teks" => "Maaf ya sering buat kamu sedih"],
            ["file" => "foto4.jpg", "teks" => "Semoga kedepannya kamu bisa lebih sering senang daripada sedihnya"],
            ["file" => "foto5.jpg", "teks" => "Moga kamu lebih sayang sama aku :v"],
            ["file" => "foto6.jpg", "teks" => "Semoga apapun yang kamu harapkan bisa segera terkabul"],
            ["file" => "foto7.jpg", "teks" => "Aku pasti akan membantu itu terwujud jika bisa kubantu"],
            ["file" => "foto8.jpg", "teks" => "Sekali lagi terimakasih banget sudah hidup ya meltin"],
            ["file" => "foto9.jpg", "teks" => "Dan ketemu aku"],
            ["file" => "foto10.jpg", "teks" => "Selamat Ulang tahun yaaaa"]
        ];

        // Tampilkan slide
        foreach ($gambar as $index => $g) {
            echo '<div class="slide'.($index == 0 ? ' active' : '').'">';
            echo '<img src="'.$g["file"].'" alt="Foto">';
            echo '<div class="text-overlay">'.$g["teks"].'</div>';
            echo '</div>';
        }
        ?>
    </div>
</div>

<!-- Audio Element -->
<audio id="bgMusic" loop>
    <source src="musik.mp3" type="audio/mpeg">
    Peramban Anda tidak mendukung elemen audio.
</audio>

<script>
    const startBtn = document.getElementById('startBtn');
    const slideshow = document.getElementById('slideshow');
    const wrapper = document.getElementById('wrapper');
    const slides = document.querySelectorAll('.slide');
    const bgMusic = document.getElementById('bgMusic');
    let currentSlide = 0;
    let interval;
    const totalSlides = slides.length;

    startBtn.addEventListener('click', () => {
        startBtn.style.display = 'none';
        slideshow.classList.add('active');
        wrapper.classList.add('active');
        
        // Putar musik
        bgMusic.play().catch(error => {
            console.log('Autoplay musik diblokir browser:', error);
        });
        
        showSlide(0);
        interval = setInterval(nextSlide, 8000); // Ganti tiap 4 detik
    });

    function showSlide(n) {
        slides.forEach((slide, index) => {
            slide.classList.remove('active');
            if (index === n) slide.classList.add('active');
        });
    }

    function nextSlide() {
        // Jika belum sampai foto terakhir, lanjut ke foto berikutnya
        if (currentSlide < totalSlides - 1) {
            currentSlide++;
            showSlide(currentSlide);
        } else {
            // Jika sudah foto terakhir, hentikan slideshow tapi musik tetap berjalan
            clearInterval(interval);
        }
    }
</script>

</body>
</html>
