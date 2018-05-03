

<?php if ($alert['status'] == 'success' || $alert['status'] == 'error'): ?>

    <div class="alert alert-<?=$alert['status'];?>">
        <strong><?=ucfirst($alert['status']);?>!</strong> <?=$alert['message']; ?>.
    </div>

<?php endif; ?>

<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Todo Item</th>
            <th scope="col">Complete</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($output as $todo): ?>

            <?php if ($editItemid != $todo['todo_id']): ?>
                <tr>
                    <th scope="row">
                        <?=$todo['todo_id']?>
                    </th>
                    <td>
                        <?=$todo['content']?><br/>
                        <div class="small-text">
                        <em>created: <?=$todo['date_created']?></em> | 
                        <em>modified: <?=$todo['date_modified']?></em>
                        </div>
                    </td>
                    <td>
                        <div class="todo-controls">
                            <form action="/todo/complete" method="post">
                                <input type="hidden" name="id" value="<?=$todo['todo_id']?>" />
                                <button>
                                    <?php if ($todo['completed']==0): ?>
                                        <i class="fa fa-square-o" aria-hidden="true" title="not complete"></i>
                                    <?php else: ?>
                                        <i class="fa fa-check-square-o" aria-hidden="true" title="completed"></i>
                                    <?php endif; ?>
                                </button>
                            </form>
                        </div>
                    </td>
                    <td>
                        <div class="todo-controls">
                            <form action="/todo/edit/<?=$todo['todo_id']?>" method="post">
                                <button><i class="fa fa-pencil" aria-hidden="true" title="edit"></i></button>
                            </form>
                        </div>

                    </td>
                    <td>
                        <div class="todo-controls">
                            <form action="/todo/delete" method="post">
                                <input type="hidden" name="id" value="<?=$todo['todo_id']?>" />
                                <button><i class="fa fa-trash" aria-hidden="true" title="delete"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <th scope="row">&nbsp;</th>
                    <td>
                        <form action="/todo/edit" method="post">
                            <input type="hidden" name="id" value="<?=$todo['todo_id']?>" />
                            <textarea name="content"></textarea><br/>
                            <button>Update This Todo Item</button>
                        </form>
                    </td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>

        <tr>
            <th scope="row">&nbsp;</th>
            <td>
                <form action="/todo/new" method="post">
                    <input type="hidden" name="action" value="new" />
                    <textarea name="content"></textarea><br/>
                    <button>Save New Todo Item</button>
                </form>
            </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>

    </tbody>
</table>