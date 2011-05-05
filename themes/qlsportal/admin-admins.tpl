<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-header.tpl'; ?>
            <tr>
              <td valign="top" height="100">
                <div class="admin-top-block">
                  <div style="padding: 10px;">
                    <span class="msg-error">
                      <?php echo Messages::getInstance()->getMessage('admins-add-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('admins-delete-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('admins-edit-error', true); ?>
                    </span>
                    <span class="msg-message">
                      <?php echo Messages::getInstance()->getMessage('admins-add-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('admins-delete-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('admins-edit-message', false); ?>
                    </span>
                  </div>
                  <form action="<?php echo Settings::getAddressSite(); ?>admin/admins/add/" method="POST">
                    <table border="0" cellspacing="0">
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <b>Добавить Администратора</b><br /><br />
                        </td>
                      </tr>
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
                          Отображаемое имя
                        </td>
                        <td>
                          <input type="input" name="name" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          E-mail
                        </td>
                        <td>
                          <input type="input" name="email" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Админ?
                        </td>
                        <td>
                          <input type="checkbox" name="role" value="1" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Доступ к баннерам
                        </td>
                        <td>
                          <select name="advs[]" multiple size="3">
                            <?php foreach($tpl->advs as $adv) { ?>
                            <option value="<?php echo $adv['id']; ?>"><?php echo $adv['advname']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <input type="submit" name="submit" value="Добавить" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </div>
              </td>
            </tr>
            <tr>
              <td valign="top">
                <div class="admin-bottom-block">
                  <?php if($tpl->admin) { ?>
                  <form id="form-edit-editor" action="<?php echo Settings::getAddressSite(); ?>admin/admins/edit/" method="POST">
                    <input type="hidden" name="id" value="<?php echo $tpl->admin['id']; ?>" />
                    <table cellspacing="2">
                      <tr>
                        <td>
                          Логин
                        </td>
                        <td>
                          <input type="input" name="login" value="<?php echo $tpl->admin['login']; ?>" />
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
                          Имя
                        </td>
                        <td>
                          <input type="input" name="name" value="<?php echo $tpl->admin['name']; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          E-mail
                        </td>
                        <td>
                          <input type="input" name="email" value="<?php echo $tpl->admin['email']; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Админ?
                        </td>
                        <td>
                          <input type="checkbox" name="role" value="1" <?php echo $tpl->admin['role'] === 'admin' ? 'checked' : ''; ?> />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Доступ к баннерам
                        </td>
                        <td>
                          <select name="advs[]" multiple size="3">
                            <?php foreach($tpl->advs as $adv) { ?>
                            <option value="<?php echo $adv['id']; ?>" <?php echo (array_search($adv['id'], $tpl->users_advs) !== false ? 'selected' : ''); ?>><?php echo $adv['advname']; ?></option>
                            <?php } ?>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <input type="submit" name="submit" value="Редактировать" />
                        </td>
                      </tr>
                    </table>
                  </form>
                  <?php } else if($tpl->admins) { ?>
                  <div class="admin-admins-each">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr class="list-title">
                        <td>
                          Логин
                        </td>
                        <td>
                          Имя
                        </td>
                        <td>
                          E-mail
                        </td>
                        <td>
                          Действие
                        </td>
                      </tr>
                      <?php foreach($tpl->admins as $admin) { ?>
                      <tr class="list-body">
                        <td>
                          <?php echo $admin['login']; ?>
                        </td>
                        <td>
                          <?php echo $admin['name']; ?>
                        </td>
                        <td>
                          <?php echo $admin['email']; ?>
                        </td>
                        <td>
                          [ <a href="<?php echo Settings::getAddressSite(); ?>admin/admins/edit/<?php echo $admin['id']; ?>">Редактировать</a> ]
                          [ <a href="<?php echo Settings::getAddressSite(); ?>admin/admins/delete/<?php echo $admin['id']; ?>" class="confirm-link">Удалить</a> ]
                        </td>
                      </tr>
                      <?php } ?>
                    </table>
                  </div>
                  <?php } ?>
                </div>
              </td>
            </tr>
<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-footer.tpl'; ?>
