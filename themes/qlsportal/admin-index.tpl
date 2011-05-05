<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-header.tpl'; ?>
            <tr>
              <td valign="top">
                <div class="admin-top-block">
                  <div style="padding: 10px;">
                    <span class="msg-error">
                      <?php echo Messages::getInstance()->getMessage('login-error', true); ?>
                    </span>
                  </div>
                  <?php if($_SESSION['role'] === 'guest') { ?>
                  <form action="<?php echo Settings::getAddressSite(); ?>admin/login/" method="POST">
                    <table border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td>
                          Логин
                        </td>
                        <td>
                          <input type="input" name="login" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Пароль
                        </td>
                        <td>
                          <input type="password" name="password" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <input type="submit" name="submit" value="Войти" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <?php } ?>
                </div>
              </td>
            </tr>
            
<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-footer.tpl'; ?>
