<div class="bg-gray-50 rounded-lg border border-gray-200 px-4 py-3 mb-4 flex flex-col md:flex-row gap-3 items-center">
                <input id="studentSearch" type="text" placeholder="Search student name or email..." class="w-full md:w-1/2 px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200" />
                <select id="classFilter" class="px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-200">
                    <option value="">All Classes</option>
                    <?php if (isset($classNames) && is_array($classNames)): ?>
                        <?php foreach ($classNames as $cid => $cname): ?>
                            <option value="<?php echo htmlspecialchars($cid); ?>"><?php echo htmlspecialchars($cname); ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>