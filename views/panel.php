<div class="col-md-12 col-xs-12">
    <h1>Size Table</h1>
    <h4 style="color: blue">Program przyjmuje TYLKO pliki CSV rozdzielany przecinkami</h4>
</div>
<div  class="col-md-12 col-xs-12">
    <h2>Wgranie pliku</h2>
    <?php if(!empty($uploadInfo)) { echo $uploadInfo; } ?>
</div>
<div  class="col-md-12 col-xs-12">
    <?php  include(dirname(__FILE__) . '/upload.php'); ?>
</div>

<div  class="col-md-12 col-xs-12">
<h2>Lista plików</h2>
    <?php if(!empty($_GET['remove'])) { echo "<h2 style='color: green'>Plik został usunięty</h2>"; } ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nazwa pliku</th>
                <th>Funkcja</th>
                <th>Shotcode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($files as $file): ?>
            <?php $noExtensionFile = explode('.', $file); ?>
            <tr>
                <td><?php echo $file; ?></td>
                <td><a href="/wp-admin/admin.php?page=chasil_sizeTableMenu&delete=yes&file=<?php echo $file; ?>">Usuń</a></td>
                <td>[chasilSizeTable fileName="<?php echo $noExtensionFile[0]; ?>"]</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>