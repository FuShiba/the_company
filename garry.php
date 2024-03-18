<tbody>
                <?php
                    while ($user = $all_users->fetch_assoc()) {
                ?>
                    
                    <tr>
                        <td>
                            <?php
                                if ($user['photo']) {
                            ?>
                                <img src="../assets/images/<?=$user['photo']?>" alt="<?= $user['photo'] ?>" class="d-block mx-auto dashboard-photo">
                            <?php
                                }else{
                            ?>
                                <i class="fa-solid fa-user text-secondary d-block text-center dashboard-icon"></i>
                            <?php
                                }
                            ?>
                        </td>
                        <td><?= $user['id'] ?></td>
                        <td><?= $user['first_name'] ?></td>
                        <td><?= $user['last_name'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td>
                            <?php
                                if ($_SESSION['id'] == $user['id']) { //true
                            ?>
                                <a href="#" class="btn btn-warning" title="Edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <a href="#" class="btn btn-danger" title="Delete">
                                    <i class="fa-regular fa-trash-can"></i>
                                </a>
                            <?php
                                }
                            ?>
                        </td>
                    </tr>


                <?php
                    }
                ?>
            </tbody>