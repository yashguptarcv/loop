<div id="userModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h2 id="formTitle" class="text-xl font-semibold mb-4">Create Admin</h2>
        <form id="userForm" class="form-ajax" method="POST" action="{{ route('admin.settings.users.store') }}">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">


            <input type="hidden" name="id" id="userId">

            <div class="mb-4">
                <label class="block mb-1">Name</label>
                <input type="text" name="name" id="name" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Email</label>
                <input type="email" name="email" id="email" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Role</label>
                <select name="role_id" id="role_id" class="form-select w-full" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Password</label>
                <input type="password" name="password" class="form-input w-full">
            </div>

            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="btn btn-secondary mr-2">Cancel</button>
                <button type="submit" name="button" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>