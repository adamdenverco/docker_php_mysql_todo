
<?php if ($error): ?>

    <p><?=$error;?></p>

<?php else: ?>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Username</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($output as $user): ?>

                <tr>
                    <th scope="row"><?=$user['id']?></th>
                    <td><?=$user['username']?></td>
                    <td><?=$user['firstname']?></td>
                    <td><?=$user['lastname']?></td>
                </tr>

            <?php endforeach; ?>

        </tbody>
    </table>


<?php endif; ?>
