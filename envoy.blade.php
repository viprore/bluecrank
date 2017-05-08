@servers(['web' => 'bluecrank_deployer'])

<?php $whatever = 'hola, whatever'; ?>

@task('deploy', ['on' => 'web'])
echo {{ $whatever }}
@endtask