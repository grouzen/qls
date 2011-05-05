<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-header.tpl'; ?>
            <tr>
              <td valign="top" height="100">
                <div class="admin-top-block">
                  <div style="padding: 10px;">
                    <span class="msg-error">
                      <?php echo Messages::getInstance()->getMessage('news-add-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('news-delete-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('news-master-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('news-edit-error', true); ?>
                      <?php echo Messages::getInstance()->getMessage('news-delet_message-error', true); ?>
                    </span>
                    <span class="msg-message">
                      <?php echo Messages::getInstance()->getMessage('news-add-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('news-delete-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('news-master-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('news-edit-message', false); ?>
                      <?php echo Messages::getInstance()->getMessage('news-delete_image-message', false); ?>
                    </span>
                  </div>
                  <form action="<?php echo Settings::getAddressSite(); ?>admin/news/add/" method="POST">
                    <table border="0" cellspacing="0">
                      <tr>
                        <td>
                          &nbsp;
                        </td>
                        <td>
                          <b>Добавить новость:</b><br /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Заголовок
                        </td>
                        <td>
                          <input type="input" name="title" size="34" /><br />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Текст
                        </td>
                        <td>
                          <textarea name="body" rows="15" cols="100"></textarea>
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
                  <?php if($tpl->onenews) { ?>
                  <form id="form-edit-news" enctype="multipart/form-data" action="<?php echo Settings::getAddressSite(); ?>admin/news/edit/" method="POST">
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />
                    <input type="hidden" name="id" value="<?php echo $tpl->onenews['id']; ?>" />
                    <table cellspacing="2">
                      <tr>
                        <td>
                          Заголовок
                        </td>
                        <td>
                          <input type="input" name="title" size="34" value="<?php echo $tpl->onenews['title']; ?>" />
                        </td>
                      </tr>
                      <tr>
                        <td>
                          Текст
                        </td>
                        <td>
                          <textarea name="body" rows="15" cols="100"><?php echo $tpl->onenews['body']; ?></textarea>
                        </td>
                      </tr>
                      <!--
                      <tr>
                        <td>
                          Изображения
                        </td>
                        <td>
                          <table border="0" cellspacing="2" cellpadding="2">
                            <tr>
                              <?php foreach($tpl->onenews['files'] as $file) { ?>
                              <td>
                                <img class="admin-news-files" src="<?php echo Settings::getAddressSite() . 'files/' . $file['path']; ?>" />
                                <br />
                                [ <a href="<?php echo Settings::getAddressSite() . 'admin/news/delete_image/' . $file['id']; ?>">Удалить</a> ]
                              </td>
                              <?php } ?>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      
                      <tr>
                        <td>
                          Файлы
                        </td>
                        <td>
                          <div id="form-edit-news-files">
                            <input type="file" name="files[]" />
                          </div>
                        </td>
                      </tr>
                      -->
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
                  <?php } else if($tpl->news) { ?>
                  
                  <div class="admin-news-master">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td>
                          <div class="admin-news-title">
                            <b>( Главная )</b>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php if(!empty($tpl->main_news['image'])) { ?>
                          <div class="admin-news-image-top">
                            <img class="admin-news-image-top" src="<?php echo Settings::getAddressSite() . 'files/' . $tpl->main_news['image']['path']; ?>" />
                          </div>
                          <?php } ?>
                          <div class="admin-news-body">
                            <?php echo $tpl->main_news['body']; ?>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="admin-news-links">
                            [ <a href="<?php echo Settings::getAddressSite(); ?>admin/news/delete/<?php echo $tpl->main_news['id']; ?>" class="confirm-link">Удалить</a> ]
                            [ <a href="<?php echo Settings::getAddressSite(); ?>admin/news/edit/<?php echo $tpl->main_news['id']; ?>">Редактировать</a> ]
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>

                  
                  <?php foreach($tpl->news as $news) { ?>
                  <div class="admin-news-each">
                    <table width="100%" border="0" cellspacing="2" cellpadding="2">
                      <tr>
                        <td>
                          <div class="admin-news-title">
                            <?php echo $news['title']; ?>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <?php if(!empty($news['image'])) { ?>
                          <div class="admin-news-image-top">
                            <img class="admin-news-image-top" src="<?php echo Settings::getAddressSite() . 'files/' . $news['image']['path']; ?>" />
                          </div>
                          <?php } ?>
                          <div class="admin-news-body">
                            <?php echo $news['body']; ?>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div class="admin-news-links">
                            [ <a href="<?php echo Settings::getAddressSite(); ?>admin/news/delete/<?php echo $news['id']; ?>" class="confirm-link">Удалить</a> ]
                            [ <a href="<?php echo Settings::getAddressSite(); ?>admin/news/edit/<?php echo $news['id']; ?>">Редактировать</a> ]
                            [ <a href="<?php echo Settings::getAddressSite(); ?>admin/news/master/<?php echo $news['id']; ?>" class="confirm-link">Сделать главной</a> ]
                          </div>
                        </td>
                      </tr>
                    </table>
                  </div>
                  <?php } ?>
                  <?php } ?>
                </div>
              </td>
            </tr>
<?php include_once THEMES . Settings::getTheme() . '/plugins/admin-footer.tpl'; ?>
