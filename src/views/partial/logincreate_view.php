<?php if (isset($_SESSION['user_id'])): ?>
        <button><a href="logout">Logout</a></button>
    <?php else: ?>
        <button><a href="login">Login</a></button> | 
        <button><a href="create">Create Account</a></button>
    <?php endif; ?>