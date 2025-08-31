<form id="signupStudentForm" class="space-y-4 hidden fade-in">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-ama-gray mb-2">Full Name</label>
            <div class="relative">
                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="text"
                    name="fullname"
                    placeholder="Enter your complete name"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Student ID</label>
            <div class="relative">
                <i class="fas fa-id-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="text"
                    name="student_id"
                    placeholder="Your student ID"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Grade Level</label>
            <div class="relative">
                <i class="fas fa-layer-group absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <select
                    name="grade_level"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                    required>
                    <option value="">Select grade</option>
                    <option value="grade 11">Grade 11</option>
                    <option value="grade 12">Grade 12</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Strand</label>
            <div class="relative">
                <i class="fas fa-route absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <select
                    name="strand"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray appearance-none"
                    required>
                    <option value="">Select strand</option>
                    <option value="STEM">STEM</option>
                    <option value="ABM">ABM</option>
                    <option value="HUMSS">HUMSS</option>
                    <option value="GAS">GAS</option>
                    <option value="TVL-ICT">TVL-ICT</option>
                    <option value="TVL-HE">TVL-HE</option>
                </select>
                <i class="fas fa-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none text-xs"></i>
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-ama-gray mb-2">Email Address</label>
            <div class="relative">
                <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                <input
                    type="email"
                    name="email"
                    placeholder="Your email address"
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
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
                    class="w-full pl-10 pr-3 py-2.5 bg-gray-50 border-2 border-gray-200 rounded-lg focus:outline-none focus:border-purple-500 focus:bg-white transition-all duration-200 text-sm text-ama-gray"
                    required>
            </div>
        </div>
    </div>

    <button
        type="submit"
        class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 px-4 rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl text-sm disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none">
        <span class="student-btn-text">Create Student Account</span>
        <span class="student-btn-loading hidden"><span class="loading-spinner"></span> Creating Account...</span>
    </button>

    <div class="text-center">
        <button type="button" class="text-xs text-ama-blue hover:text-ama-navy font-semibold transition-colors" onclick="switchTab('signin')">
            Already have an account? Sign in here
        </button>
    </div>
</form>