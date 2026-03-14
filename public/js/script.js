// 1. التبديل بين الأقسام (إظهار وإخفاء الصناديق)
const toSignup = document.getElementById('toSignup');
const toLogin = document.getElementById('toLogin');
const toForgot = document.getElementById('toForgot');
const backToLoginFromForgot = document.getElementById('backToLoginFromForgot');

const loginSection = document.getElementById('loginSection');
const signupSection = document.getElementById('signupSection');
const forgotSection = document.getElementById('forgotSection');

const showSection = (sectionToShow) => {
    if(loginSection) loginSection.style.display = 'none';
    if(signupSection) signupSection.style.display = 'none';
    if(forgotSection) forgotSection.style.display = 'none';
    sectionToShow.style.display = 'block';
};

if(toSignup) toSignup.onclick = () => showSection(signupSection);
if(toLogin) toLogin.onclick = () => showSection(loginSection);
if(toForgot) toForgot.onclick = () => showSection(forgotSection);
if(backToLoginFromForgot) backToLoginFromForgot.onclick = () => showSection(loginSection);

// 2. نظام التسجيل (Sign Up) - حفظ البيانات في المتصفح
const signupForm = document.getElementById('signupForm');
if(signupForm) {
    signupForm.onsubmit = (e) => {
        e.preventDefault();
        const email = signupForm.querySelector('input[type="email"]').value;
        const password = signupForm.querySelectorAll('input[type="password"]')[0].value;
        const confirmPass = signupForm.querySelectorAll('input[type="password"]')[1].value;

        if (password !== confirmPass) {
            alert("Passwords do not match!");
            return;
        }

        localStorage.setItem(email, password);
        alert("Account created successfully! Now you can login.");
        showSection(loginSection);
    };
}

// 3. وظائف شاشات الترحيب (Onboarding)
function nextStep(stepNumber) {
    // إخفاء كل الخطوات
    document.querySelectorAll('.onboard-step').forEach(step => {
        step.style.display = 'none';
    });
    // إظهار الخطوة المطلوبة
    const targetStep = document.getElementById('step' + stepNumber);
    if(targetStep) targetStep.style.display = 'block';
}

function skipOnboarding() {
    // التوجيه النهائي للموقع بعد الشاشات أو عند الضغط على Skip
    window.location.href = 'home-logged-in.html'; 
}

// 4. نظام تسجيل الدخول مع شريط التحميل ثم شاشات الترحيب
const loginForm = document.getElementById('loginForm');
if(loginForm) {
    loginForm.onsubmit = (e) => {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value;
        const pass = document.getElementById('loginPass').value;
        const savedPassword = localStorage.getItem(email);

        if (savedPassword && savedPassword === pass) {
            const loader = document.getElementById('loaderScreen');
            const bar = document.getElementById('loaderBar');
            
            if(loader && bar) {
                loader.style.display = 'flex';
                let progress = 0;
                const interval = setInterval(() => {
                    progress += 10; // سرعة الشريط
                    bar.style.width = progress + '%';
                    
                    if (progress >= 100) {
                        clearInterval(interval);
                        // بعد انتهاء التحميل: إخفاء التحميل وإظهار شاشة الترحيب الأولى
                        loader.style.display = 'none';
                        const onboarding = document.getElementById('onboardingScreen');
                        if(onboarding) {
                            onboarding.style.display = 'flex';
                        } else {
                            // إذا لم تكن شاشات الترحيب موجودة، ادخل فوراً
                            window.location.href = 'home-logged-in.html';
                        }
                    }
                }, 80); 
            } else {
                window.location.href = 'home-logged-in.html';
            }
        } else {
            alert("Invalid! This account does not exist or password is wrong.");
        }
    };
}
