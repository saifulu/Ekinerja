// ... existing code ...
        if (!token) {
            window.location.href = '/login';
        } else if (user.role !== 'admin') {
            // Redirect user biasa ke dashboard user
            window.location.href = '/user-dashboard';
        } else {
            document.getElementById('userInfo').innerHTML = `
                <h3 class="font-bold">User Info:</h3>
                <p>Name: ${user.name}</p>
                <p>Email: ${user.email}</p>
                <p>Role: ${user.role}</p>
            `;
            document.getElementById('userWelcome').textContent = `Selamat datang, ${user.name}`;
        }
// ... existing code ...