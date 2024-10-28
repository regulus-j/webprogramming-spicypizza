    <!-- Account Creation Modal -->
     <?php
     include_once "add_account1.php";
     ?>

    <div 
    class="modal"
    id="modal-add-user"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    tabindex="-1"
    aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountModalLabel">Create New Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>
                <div class="modal-body">
                    <form id="addAccountForm" method="post" onsubmit="return submitForm(event)">
                        <div class="form-group">
                            <label for="first_name">First Name:</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($firstName) ?>">
                            <span class="error text-danger" id="first_name_err"></span>
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name:</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($lastName) ?>">
                            <span class="error text-danger" id="last_name_err"></span>
                        </div>
                        <div class="form-group">
                            <label for="username">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username) ?>">
                            <span class="error text-danger" id="username_err"></span>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <span class="error text-danger" id="password_err"></span>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            <span class="error text-danger" id="confirm_password_err"></span>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>