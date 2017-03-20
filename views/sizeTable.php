<div class='container'>
    <div class='content col-xs-12 col-md-6 col-md-offset-2'>
        <table class='table table-striped'>
            <thead>
                <tr>
                    <th>Rozmiar</th>
                    <th>Długość</th>
                    <th>Szerokość</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($tableData as $table): ?>
                    <tr><?php foreach($table as $key): ?>
                        <td><?php echo $key; ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>