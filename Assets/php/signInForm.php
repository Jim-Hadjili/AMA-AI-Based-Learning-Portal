<form id="signinForm" class="space-y-4 fade-in">
    <div class="space-y-4">
        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email address"
                    class="w-full pl-10 pr-3 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-ama-blue focus:bg-white transition-all duration-200 text-sm text-ama-gray input-focus"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    class="w-full pl-10 pr-3 py-3 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-ama-blue focus:bg-white transition-all duration-200 text-sm text-ama-gray input-focus"
                    required>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between text-xs">
        <a href="#" class="text-ama-blue hover:text-ama-navy font-semibold transition-colors">
            Forgot password?
        </a>
    </div>

    <button
        type="submit"
        class="w-full bg-ama-blue hover:bg-ama-navy text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
        <span class="signin-btn-text">Sign In to Dashboard</span>
        <span class="signin-btn-loading hidden"><span class="loading-spinner"></span> Signing In...</span>
    </button>

    <!-- Registration Options - Side by Side -->
    <div class="pt-4 border-t-2 border-gray-100">
        <p class="text-center text-xs font-semibold text-ama-gray mb-3">
            New to AMA College?
        </p>
        <div class="grid grid-cols-2 gap-2">
            <button
                type="button"
                class="flex flex-col items-center justify-center px-3 py-2.5 bg-white text-emerald-600 border-2 border-emerald-600 rounded-lg hover:bg-emerald-50 transition-all duration-200 font-medium text-xs"
                onclick="switchTab('signup_teacher')">
                <i class="fas fa-chalkboard-teacher mb-1 text-emerald-600"></i>
                <span>Sign Up as a Teacher</span>
            </button>
            <button
                type="button"
                class="flex flex-col items-center justify-center px-3 py-2.5 bg-white text-purple-600 border-2 border-purple-600 rounded-lg hover:bg-purple-50 transition-all duration-200 font-medium text-xs"
                onclick="switchTab('signup_student')">
                <i class="fas fa-user-graduate mb-1 text-purple-600"></i>
                <span>Sign Up as a Student</span>
            </button>
        </div>
    </div>
</form>