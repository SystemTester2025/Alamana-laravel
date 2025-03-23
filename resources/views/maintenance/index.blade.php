<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->title ?? 'الأمانة للاستيراد والتصدير' }} - الموقع قيد الصيانة</title>
    <link rel="icon" href="{{ asset($settings->favicon ?? 'images/logo/favicon.svg') }}" type="image/x-icon">
    
    <!-- Include Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
    
    <!-- Include Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #32936f;
            --secondary-color: #26734c;
            --accent-color: #ffc107;
            --text-color: #333;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            height: 100vh;
            overflow: hidden;
            position: relative;
        }
        
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 0;
        }
        
        .maintenance-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1;
        }
        
        .maintenance-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            padding: 2.5rem;
            max-width: 800px;
            width: 90%;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .logo {
            height: 100px;
            width: 100px;
            max-width: 200px;
            margin-left: 200px
            height: auto;
            margin-bottom: 1.5rem;
            padding-left: 20px;
        }
        
        h1 {
            color: var(--primary-color);
            margin-bottom: 1rem;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }
        
        h1:after {
            content: '';
            position: absolute;
            width: 0;
            height: 3px;
            bottom: -5px;
            left: 0;
            background-color: var(--accent-color);
            animation: underline 3s ease forwards;
        }
        
        @keyframes underline {
            to { width: 100%; }
        }
        
        .maintenance-message {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .word-cycle {
            color: var(--primary-color);
            font-weight: bold;
            min-width: 120px;
            display: inline-block;
            text-align: center;
        }
        
        .tools-icon {
            font-size: 4rem;
            color: var(--primary-color);
            margin: 1.5rem 0;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .back-soon {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.5rem;
            color: var(--secondary-color);
        }
        
        .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.9);
            padding: 1rem;
            text-align: center;
            font-size: 0.9rem;
            color: #777;
            z-index: 2;
        }
        
        .footer img {
            height: 30px;
            margin-bottom: 0.5rem;
        }
        
        .social-links {
            margin-top: 1.5rem;
        }
        
        .social-links a {
            display: inline-flex;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-color);
            color: var(--primary-color);
            align-items: center;
            justify-content: center;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
        }
        
        @media (max-width: 768px) {
            .maintenance-box {
                padding: 1.5rem;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            .maintenance-message {
                font-size: 1rem;
            }
            
            .back-soon {
                font-size: 1.2rem;
            }
        }
    </style>
    
    <!-- Include Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <div class="maintenance-container">
        <div class="maintenance-box">
            @if($settings->logo)
                <img src="{{ asset($settings->logo) }}" alt="{{ $settings->title ?? 'الأمانة' }}" class="logo">
            @else
                <h2 class="mb-4">{{ $settings->title ?? 'الأمانة للاستيراد والتصدير' }}</h2>
            @endif
            
            <h1>موقعنا قيد الصيانة</h1>
            
            <div class="tools-icon">
                <i class="fas fa-tools"></i>
            </div>
            
            <p class="maintenance-message">
                نحن نعمل حاليًا على <span class="word-cycle" id="word-cycle">تحسين</span> موقعنا لتقديم تجربة أفضل لكم.
                نعتذر عن أي إزعاج ونشكركم على صبركم وتفهمكم.
            </p>
            
            <div class="social-links">
                @if($settings->facebook)
                    <a href="{{ $settings->facebook }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                @endif
                
                @if($settings->twitter)
                    <a href="{{ $settings->twitter }}" target="_blank"><i class="fab fa-twitter"></i></a>
                @endif
                
                @if($settings->instagram)
                    <a href="{{ $settings->instagram }}" target="_blank"><i class="fab fa-instagram"></i></a>
                @endif
                
                @if($settings->linkedin)
                    <a href="{{ $settings->linkedin }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                @endif
            </div>
            
            <p class="back-soon">سنعود قريبًا!</p>
        </div>
    </div>
    
    <div class="footer">
        <img src="{{ asset($settings->footer_logo ?? 'images/logo/footer_logo.svg') }}" alt="Elnakieb">
        <p>تطوير وتصميم <a href="mailto:ahmedrmohamed2017@gmail.com">النقيب</a>
        - جميع الحقوق محفوظة &copy; {{ date('Y') }}</p>
    </div>
    
    <!-- Include Particles.js -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Configure particles
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 50,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#32936f"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 5,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#32936f",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "repulse": {
                        "distance": 100,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    }
                }
            },
            "retina_detect": true
        });
        
        // Word cycling animation
        document.addEventListener('DOMContentLoaded', function() {
            const words = ["تحسين", "تطوير", "تحديث", "ترقية"];
            const cycleElement = document.getElementById('word-cycle');
            let currentIndex = 0;
            
            function cycleWords() {
                cycleElement.style.opacity = 0;
                
                setTimeout(() => {
                    currentIndex = (currentIndex + 1) % words.length;
                    cycleElement.textContent = words[currentIndex];
                    cycleElement.style.opacity = 1;
                }, 500);
            }
            
            setInterval(cycleWords, 3000);
        });
    </script>
</body>
</html> 