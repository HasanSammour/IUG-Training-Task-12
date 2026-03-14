<!-- Onboarding Section - Interactive Welcome Tour for Students -->
@if(session('show_onboarding_dashboard') && Auth::user()->hasRole('student'))
    <div id="onboardingOverlay"
        style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); z-index: 10001; display: flex; align-items: center; justify-content: center; padding: 40px 20px;">
        <div class="onboarding-card"
            style="width: 90%; max-width: 480px; background: white; border-radius: 30px; padding: 30px; box-shadow: 0 30px 60px rgba(0,0,0,0.3); position: relative; overflow: hidden; margin: 20px auto;">

            <!-- Decorative Elements -->
            <div
                style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(102, 126, 234, 0.1); border-radius: 50%;">
            </div>
            <div
                style="position: absolute; bottom: -50px; left: -50px; width: 150px; height: 150px; background: rgba(118, 75, 162, 0.1); border-radius: 50%;">
            </div>

            <!-- Step 1: Welcome with Fixed Logo -->
            <div class="onboarding-step" id="step1" style="display: block; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <!-- Fixed Logo - No white background -->
                    <div style="width: 100px; height: 100px; margin: 0 auto 20px; position: relative;">
                        <!-- Rotating Ring Animation -->
                        <div
                            style="position: absolute; top: -5px; left: -5px; right: -5px; bottom: -5px; border: 3px solid transparent; border-top-color: #667eea; border-right-color: #764ba2; border-radius: 50%; animation: spin 3s linear infinite;">
                        </div>
                        <div
                            style="position: absolute; top: -2px; left: -2px; right: -2px; bottom: -2px; border: 3px solid transparent; border-bottom-color: #10b981; border-left-color: #f59e0b; border-radius: 50%; animation: spin 4s linear infinite reverse;">
                        </div>

                        <!-- Logo with Transparent Background -->
                        <div
                            style="width: 100%; height: 100%; background: transparent; border-radius: 50%; display: flex; align-items: center; justify-content: center; overflow: hidden; animation: float 3s ease-in-out infinite;">
                            <img src="{{ asset('images/logo-icon.jpeg') }}" alt="Shifra Logo"
                                style="width: 80%; height: 80%; object-fit: contain; border-radius: 50%; box-shadow: 0 5px 15px rgba(45, 62, 80, 0.2);">
                        </div>
                    </div>

                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">Welcome to Shifra!
                    </h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Your personalized
                        learning journey starts here. Let's take a quick tour of what awaits you as a student.</p>
                </div>

                <!-- Progress Dots Container - FIXED with IDs -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 25px; height: 30px;">
                    <div class="step-dot" id="dot1-1"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot1-2"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot1-3"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot1-4"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot1-5"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot1-6"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn-next" onclick="nextStep(2)"
                        style="background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Start Tour <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn-skip" onclick="finishOnboarding()"
                        style="background: #f1f5f9; color: #64748b; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">Skip
                        Tour</button>
                </div>
            </div>

            <!-- Step 2: Learning Path -->
            <div class="onboarding-step" id="step2" style="display: none; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: bounce 2s infinite;">
                        <i class="fas fa-route" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">Learning Path AI
                    </h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Our AI creates a
                        personalized roadmap just for you, recommending courses based on your goals and progress.</p>
                </div>

                <!-- Animated Path Visualization -->
                <div
                    style="display: flex; align-items: center; justify-content: space-between; margin: 20px 0; padding: 15px; background: #f8fafc; border-radius: 16px;">
                    <div style="text-align: center;">
                        <div
                            style="width: 40px; height: 40px; background: #2d3e50; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px; animation: pulse 2s infinite;">
                            1</div>
                        <p style="font-size: 11px; margin-top: 5px;">Start</p>
                    </div>
                    <div
                        style="flex: 1; height: 2px; background: linear-gradient(90deg, #2d3e50, #10b981); position: relative;">
                        <div
                            style="width: 8px; height: 8px; background: #10b981; border-radius: 50%; position: absolute; right: -4px; top: -3px; animation: ping 2s infinite;">
                        </div>
                    </div>
                    <div style="text-align: center;">
                        <div
                            style="width: 40px; height: 40px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                            2</div>
                        <p style="font-size: 11px; margin-top: 5px;">Progress</p>
                    </div>
                    <div style="flex: 1; height: 2px; background: #e2e8f0;"></div>
                    <div style="text-align: center;">
                        <div
                            style="width: 40px; height: 40px; background: #cbd5e0; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: bold; font-size: 16px;">
                            3</div>
                        <p style="font-size: 11px; margin-top: 5px;">Complete</p>
                    </div>
                </div>

                <!-- Progress Dots - Step 2 -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 25px; height: 30px;">
                    <div class="step-dot" id="dot2-1"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot2-2"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot2-3"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot2-4"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot2-5"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot2-6"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn-next" onclick="nextStep(3)"
                        style="background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn-skip" onclick="finishOnboarding()"
                        style="background: #f1f5f9; color: #64748b; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">Skip
                        Tour</button>
                </div>
            </div>

            <!-- Step 3: Live Sessions -->
            <div class="onboarding-step" id="step3" style="display: none; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #3182ce, #2563eb); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: wave 2s infinite;">
                        <i class="fas fa-video" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">Live Sessions</h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Join interactive live
                        sessions with instructors via Google Meet or Zoom. Never miss a class with smart reminders.</p>
                </div>

                <!-- Animated Session Cards -->
                <div style="display: flex; gap: 10px; margin: 20px 0;">
                    <div
                        style="flex: 1; background: #f0f9ff; border-radius: 12px; padding: 12px; border: 1px solid #bae6fd; animation: slideUp 0.5s ease;">
                        <i class="fas fa-video"
                            style="color: #3182ce; font-size: 18px; margin-bottom: 6px; display: block;"></i>
                        <p style="font-size: 11px; font-weight: 600;">Today 3:00 PM</p>
                        <p style="font-size: 10px; color: #64748b;">Web Development</p>
                    </div>
                    <div
                        style="flex: 1; background: #fef3c7; border-radius: 12px; padding: 12px; border: 1px solid #fde68a; animation: slideUp 0.6s ease;">
                        <i class="fas fa-video"
                            style="color: #d97706; font-size: 18px; margin-bottom: 6px; display: block;"></i>
                        <p style="font-size: 11px; font-weight: 600;">Tomorrow 10 AM</p>
                        <p style="font-size: 10px; color: #64748b;">Data Science</p>
                    </div>
                </div>

                <!-- Progress Dots - Step 3 -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 25px; height: 30px;">
                    <div class="step-dot" id="dot3-1"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot3-2"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot3-3"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot3-4"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot3-5"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot3-6"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn-next" onclick="nextStep(4)"
                        style="background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn-skip" onclick="finishOnboarding()"
                        style="background: #f1f5f9; color: #64748b; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">Skip
                        Tour</button>
                </div>
            </div>

            <!-- Step 4: Assignments -->
            <div class="onboarding-step" id="step4" style="display: none; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: shake 2s infinite;">
                        <i class="fas fa-tasks" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">Assignments</h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Submit your work and
                        get feedback from instructors. Track your grades and improve with each assignment.</p>
                </div>

                <!-- Animated Assignment Card -->
                <div style="background: #f8fafc; border-radius: 16px; padding: 15px; margin: 20px 0;">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <div
                            style="width: 36px; height: 36px; background: #fee2e2; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #dc2626; font-size: 16px;"></i>
                        </div>
                        <div style="flex: 1;">
                            <p style="font-weight: 600; font-size: 13px; margin-bottom: 2px;">JavaScript Basics</p>
                            <p style="font-size: 11px; color: #dc2626;">Due in 2 days</p>
                        </div>
                    </div>
                    <div style="height: 6px; background: #e2e8f0; border-radius: 3px; overflow: hidden;">
                        <div class="progress-bar-fill"
                            style="width: 0%; height: 100%; background: linear-gradient(90deg, #f59e0b, #d97706); border-radius: 3px; transition: width 1s ease;">
                        </div>
                    </div>
                </div>

                <!-- Progress Dots - Step 4 -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 25px; height: 30px;">
                    <div class="step-dot" id="dot4-1"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot4-2"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot4-3"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot4-4"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot4-5"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot4-6"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn-next" onclick="nextStep(5)"
                        style="background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn-skip" onclick="finishOnboarding()"
                        style="background: #f1f5f9; color: #64748b; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">Skip
                        Tour</button>
                </div>
            </div>

            <!-- Step 5: Materials -->
            <div class="onboarding-step" id="step5" style="display: none; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: bounce 2s infinite;">
                        <i class="fas fa-file-alt" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">Course Materials
                    </h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 20px;">Access all your
                        learning resources in one place. Download PDFs, watch videos, and explore external links.</p>
                </div>

                <!-- Animated Material Icons -->
                <div style="display: flex; justify-content: center; gap: 15px; margin: 20px 0;">
                    <div style="text-align: center; animation: slideUp 0.3s ease;">
                        <i class="fas fa-file-pdf" style="font-size: 32px; color: #dc2626;"></i>
                        <p style="font-size: 10px; margin-top: 4px;">PDF</p>
                    </div>
                    <div style="text-align: center; animation: slideUp 0.4s ease;">
                        <i class="fas fa-video" style="font-size: 32px; color: #2563eb;"></i>
                        <p style="font-size: 10px; margin-top: 4px;">Video</p>
                    </div>
                    <div style="text-align: center; animation: slideUp 0.5s ease;">
                        <i class="fas fa-file-powerpoint" style="font-size: 32px; color: #d97706;"></i>
                        <p style="font-size: 10px; margin-top: 4px;">Slides</p>
                    </div>
                    <div style="text-align: center; animation: slideUp 0.6s ease;">
                        <i class="fas fa-link" style="font-size: 32px; color: #10b981;"></i>
                        <p style="font-size: 10px; margin-top: 4px;">Links</p>
                    </div>
                </div>

                <!-- Progress Dots - Step 5 -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 25px; height: 30px;">
                    <div class="step-dot" id="dot5-1"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot5-2"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot5-3"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot5-4"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot5-5"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot5-6"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <button class="btn-next" onclick="nextStep(6)"
                        style="background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                        Next <i class="fas fa-arrow-right"></i>
                    </button>
                    <button class="btn-skip" onclick="finishOnboarding()"
                        style="background: #f1f5f9; color: #64748b; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease;">Skip
                        Tour</button>
                </div>
            </div>

            <!-- Step 6: Get Started -->
            <div class="onboarding-step" id="step6" style="display: none; position: relative; z-index: 2;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <div
                        style="width: 100px; height: 100px; margin: 0 auto 20px; background: linear-gradient(135deg, #2d3e50, #1a252f); border-radius: 50%; display: flex; align-items: center; justify-content: center; animation: pulse 2s infinite;">
                        <i class="fas fa-rocket" style="font-size: 50px; color: white;"></i>
                    </div>
                    <h2 style="color: #2d3e50; font-size: 24px; margin-bottom: 10px; font-weight: 700;">You're All Set!</h2>
                    <p style="color: #64748b; font-size: 14px; line-height: 1.5; margin-bottom: 15px;">Start exploring your
                        dashboard, join your first session, or generate your personalized learning path.</p>

                    <!-- Quick Action Buttons -->
                    <div style="display: flex; gap: 10px; justify-content: center; margin: 20px 0;">
                        <a href="#"
                            onclick="event.preventDefault(); finishAndRedirect('{{ route('learning-path.generate') }}', 'POST')"
                            style="background: #f0f9ff; color: #0369a1; padding: 10px 16px; border-radius: 10px; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 6px; border: 1px solid #bae6fd;">
                            <i class="fas fa-magic"></i> Generate Path
                        </a>
                        <a href="#"
                            onclick="event.preventDefault(); finishAndRedirect('{{ route('courses.public') }}', 'GET')"
                            style="background: #f0f9ff; color: #0369a1; padding: 10px 16px; border-radius: 10px; text-decoration: none; font-size: 13px; display: flex; align-items: center; gap: 6px; border: 1px solid #bae6fd;">
                            <i class="fas fa-search"></i> Browse Courses
                        </a>
                    </div>

                    <form id="generatePathForm" action="{{ route('learning-path.generate') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                </div>

                <!-- Progress Dots - Step 6 -->
                <div class="progress-steps"
                    style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-bottom: 20px; height: 30px;">
                    <div class="step-dot" id="dot6-1"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot6-2"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot6-3"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot6-4"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot6-5"
                        style="width: 8px; height: 8px; background: #cbd5e0; border-radius: 50%; transition: all 0.3s ease;">
                    </div>
                    <div class="step-dot" id="dot6-6"
                        style="width: 30px; height: 8px; background: #2d3e50; border-radius: 4px; transition: all 0.3s ease;">
                    </div>
                </div>

                <button class="btn-next" onclick="finishOnboarding()"
                    style="width: 100%; background: linear-gradient(135deg, #2d3e50, #1a252f); color: white; padding: 12px; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    Let's Go! <i class="fas fa-rocket"></i>
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Progress Dots - Fixed styling */
        .step-dot {
            transition: all 0.3s ease;
        }

        /* Logo Animations */
        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        @keyframes wave {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(5deg);
            }

            75% {
                transform: rotate(-5deg);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-3px);
            }

            75% {
                transform: translateX(3px);
            }
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Onboarding Steps Animation */
        .onboarding-step {
            animation: fadeIn 0.5s ease;
        }

        /* Hover Effects */
        .btn-next:hover,
        .btn-skip:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-next:active,
        .btn-skip:active {
            transform: translateY(0);
        }

        /* Responsive adjustments */
        @media (max-width: 480px) {
            .onboarding-card {
                padding: 20px;
            }

            .quick-action-buttons {
                flex-direction: column;
            }
        }
    </style>

    <script>
        function nextStep(stepNumber) {
            // Hide all steps
            document.querySelectorAll('.onboarding-step').forEach(step => {
                step.style.display = 'none';
            });

            // Show target step
            const targetStep = document.getElementById('step' + stepNumber);
            if (targetStep) {
                targetStep.style.display = 'block';

                // Update progress dots - Set all dots in current step to inactive first
                const dots = targetStep.querySelectorAll('.step-dot');
                dots.forEach((dot, index) => {
                    // Reset all dots to inactive (circle)
                    dot.style.width = '8px';
                    dot.style.height = '8px';
                    dot.style.background = '#cbd5e0';
                    dot.style.borderRadius = '50%';

                    // Set the current step's dot to active (rectangle)
                    if (index === stepNumber - 1) {
                        dot.style.width = '30px';
                        dot.style.height = '8px';
                        dot.style.background = '#2d3e50';
                        dot.style.borderRadius = '4px';
                    }
                });

                // Animate progress bar in step 4
                if (stepNumber === 4) {
                    setTimeout(() => {
                        const progressBar = document.querySelector('#step4 .progress-bar-fill');
                        if (progressBar) {
                            progressBar.style.width = '30%';
                        }
                    }, 300);
                }
            }
        }

        function finishOnboarding() {
            const onboardingOverlay = document.getElementById('onboardingOverlay');
            if (onboardingOverlay) {
                // Fade out animation
                onboardingOverlay.style.transition = 'opacity 0.5s ease';
                onboardingOverlay.style.opacity = '0';

                setTimeout(() => {
                    onboardingOverlay.style.display = 'none';

                    // Mark onboarding as completed in database
                    fetch('{{ route("onboarding.complete") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Onboarding completed');
                                // DO NOT RELOAD - just remove the overlay
                            }
                        })
                        .catch(error => {
                            console.error('Error completing onboarding:', error);
                            // Still hide overlay even if API fails
                            onboardingOverlay.style.display = 'none';
                        });
                }, 500);
            }
        }

        function skipOnboarding() {
            const onboardingOverlay = document.getElementById('onboardingOverlay');
            if (onboardingOverlay) {
                onboardingOverlay.style.transition = 'opacity 0.5s ease';
                onboardingOverlay.style.opacity = '0';

                setTimeout(() => {
                    onboardingOverlay.style.display = 'none';

                    // Mark as completed even when skipped
                    fetch('{{ route("onboarding.complete") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Onboarding skipped');
                            }
                        })
                        .catch(error => {
                            console.error('Error skipping onboarding:', error);
                        });
                }, 500);
            }
        }

        function finishAndRedirect(url, method = 'GET') {
            const onboardingOverlay = document.getElementById('onboardingOverlay');

            // First complete onboarding (clear flag)
            fetch('{{ route("onboarding.complete") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
                .then(() => {
                    // Hide onboarding
                    if (onboardingOverlay) {
                        onboardingOverlay.style.transition = 'opacity 0.3s ease';
                        onboardingOverlay.style.opacity = '0';
                        setTimeout(() => {
                            onboardingOverlay.style.display = 'none';

                            // Then redirect based on method
                            if (method === 'POST') {
                                document.getElementById('generatePathForm').submit();
                            } else {
                                window.location.href = url;
                            }
                        }, 300);
                    } else {
                        // If no overlay, redirect immediately
                        if (method === 'POST') {
                            document.getElementById('generatePathForm').submit();
                        } else {
                            window.location.href = url;
                        }
                    }
                });
        }
    </script>
@endif