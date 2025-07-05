<form id="signupTeacherForm" class="space-y-4 hidden fade-in">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-ama-gray mb-2">Full Name</label>
            <div class="relative">
                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="text"
                    name="fullname"
                    placeholder="Enter your complete name"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Employee ID</label>
            <div class="relative">
                <i class="fas fa-id-badge absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="text"
                    name="employee_id"
                    placeholder="Your employee ID"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Your institutional email"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Department</label>
            <div class="relative">
                <i class="fas fa-building absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <select
                    name="department"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                    required>
                    <option value="">Select department</option>
                    <option value="mathematics">Mathematics</option>
                    <option value="science">Science</option>
                    <option value="english">English</option>
                    <option value="filipino">Filipino</option>
                    <option value="social_studies">Social Studies</option>
                    <option value="ict">ICT</option>
                    <option value="business">Business</option>
                    <option value="arts">Arts</option>
                    <option value="pe_health">PE & Health</option>
                    <option value="guidance">Guidance</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Subject Expertise</label>
            <div class="relative">
                <i class="fas fa-graduation-cap absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="text"
                    name="subject_expertise"
                    placeholder="e.g., Calculus, Chemistry"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-ama-gray mb-2">Password</label>
            <div class="relative">
                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="password"
                    name="password"
                    placeholder="Create a secure password"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-emerald-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>
    </div>

    <button
        type="submit"
        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
        <span class="teacher-btn-text">Create Teacher Account</span>
        <span class="teacher-btn-loading hidden"><span class="loading-spinner"></span> Creating Account...</span>
    </button>

    <div class="text-center">
        <button type="button" class="text-xs text-ama-blue hover:text-ama-navy font-semibold transition-colors" onclick="switchTab('signin')">
            Already have an account? Sign in here
        </button>
    </div>
</form>