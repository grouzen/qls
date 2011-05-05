<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-header.tpl'; ?>
            <tr>
              <td valign="top" height="100">
                <div class="admin-top-block">
                  <div style="padding: 10px;">
                    <span class="msg-error">
                      <?php echo Messages::getInstance()->getMessage('adv-add-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('adv-delete-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('adv-edit-error', true); ?>
                    </span>
                    <span class="msg-message">
                      <?php echo Messages::getInstance()->getMessage('adv-add-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('adv-delete-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('adv-edit-message', false); ?>
                    </span>
                  </div>
                  <?php if($_SESSION['role'] === 'admin') { ?>
                  <form enctype="multipart/form-data" action="<?php echo Settings::getAddressSite(); ?>admin/adv/add/" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <table border="0" cellspacing="0">
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <b>Добавить рекламу:</b><br /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Название
                        </td>
                        <td>
                          <input type="input" name="advname" size="34" /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          URL
                        </td>
                        <td>
                          <input type="input" name="advurl" size="40" /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Файл
                        </td>
                        <td>
                          <input type="file" name="advfile" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          До
                        </td>
                        <td>
                          <select name="date_end_year">
                            <?php for($i = 2010; $i < 2020; $i++) { ?>
                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                            <?php } ?>
                          </select>
                          -
                          <select name="date_end_month">
                            <?php for($i = 1; $i < 13; $i++) { ?>
                              <option value="<?php printf('%02d', $i); ?>"><?php printf('%02d', $i); ?></option>
                            <?php } ?>
                          </select>
                          -
                          <select name="date_end_day">
                            <?php for($i = 1; $i < 32; $i++) { ?>
                              <option value="<?php printf('%02d', $i); ?>"><?php printf('%02d', $i); ?></option>
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
                  <?php } ?>
                </div>
              </td>
            </tr>
            <tr>
              <td valign="top">
                <div class="admin-bottom-block">
                  <?php if($tpl->adv) { ?>
                  <form enctype="multipart/form-data" action="<?php echo Settings::getAddressSite(); ?>admin/adv/edit/" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <input type="hidden" name="id" value="<?php echo $tpl->adv['id']; ?>" />
                    <table border="0" cellspacing="0">
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <b>Редактировать рекламу:</b><br /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Название
                        </td>
                        <td>
                          <input type="input" name="advname" size="34" value="<?php echo $tpl->adv['advname']; ?>" /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          URL
                        </td>
                        <td>
                          <input type="input" name="advurl" size="40" value="<?php echo $tpl->adv['advurl']; ?>" /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Файл
                        </td>
                        <td>
                          <input type="file" name="advfile" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          До
                        </td>
                        <td>
                          <select name="date_end_year">
                            <?php for($i = 2010; $i < 2020; $i++) { ?>
                              <option value="<?php printf('%02d', $i); ?>"><?php printf('%02d', $i); ?></option>
                            <?php } ?>
                          </select>
                          -
                          <select name="date_end_month">
                            <?php for($i = 1; $i < 13; $i++) { ?>
                              <option value="<?php printf('%02d', $i); ?>"><?php printf('%02d', $i); ?></option>
                            <?php } ?>
                          </select>
                          -
                          <select name="date_end_day">
                            <?php for($i = 1; $i < 32; $i++) { ?>
                              <option value="<?php printf('%02d', $i); ?>"><?php printf('%02d', $i); ?></option>
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
                  <?php } else if($tpl->advs) { ?>
                  <table width="100%" border="0" cellspacing="2" cellpadding="2">
                    <tr class="list-title">
                      <td>Название</td><td>Показов</td><td>Кликов</td><td>Ун. Показов</td><td>Ун. Кликов</td><td>Действия</td>
                    </tr>
                    <?php foreach($tpl->advs as $adv) { ?>
                    <tr class="list-body">
                      <td>
                        <?php echo $adv['advname']; ?>
                      </td>
                      <td>
                        <?php echo $adv['nuniq_show_count']; ?>
                      </td>
                      <td>
                        <?php echo $adv['nuniq_click_count']; ?>
                      </td>
                      <td>
                        <?php echo $adv['uniq_show_count']; ?>
                      </td>
                      <td>
                        <?php echo $adv['uniq_click_count']; ?>
                      </td>
                      <td>
                        <?php if($_SESSION['role'] === 'admin') { ?>
                        <a href="<?php echo Settings::getAddressSite() . 'admin/adv/edit/' . $adv['id']; ?>">[Редактировать]</a><br />
                        <a href="<?php echo Settings::getAddressSite() . 'admin/adv/delete/' . $adv['id']; ?>" class="confirm-link">[Удалить]</a><br />
                        <a href="<?php echo Settings::getAddressSite() . 'admin/adv/avoid/' . $adv['id']; ?>" class="confirm-link">[Обнулить]</a>
                        <?php } ?>
                      </td>
                    </tr>
                    <?php } ?>
                  </table>
                  <?php } ?>
                </div>
              </td>
            </tr>
<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-footer.tpl'; ?>
