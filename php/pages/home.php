<?php
/*
 * Copyright 2014 rintintin.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
?>
<div class="container">
    <form class="form-signin" role="form">
        <h2 class="form-signin-heading">Влезте в профила си</h2>
        <input type="email" class="form-control" placeholder="Email" required autofocus>
        <input type="password" class="form-control" placeholder="Парола" required>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Запомни ме
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button><br>
        <p class="text-center"><a href="<?php echo ROOT_DIR ?>register">Нямате профил? Регистрирайте се. <i class="fa fa-external-link"></i></a></p>
    </form>
</div> <!-- /container -->
