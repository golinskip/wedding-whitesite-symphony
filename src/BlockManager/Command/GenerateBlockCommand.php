<?php
// src/Command/CreateUserCommand.php
namespace App\BlockManager\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class GenerateBlockCommand extends Command
{
    protected $output;

    protected function configure()
    {
        $this
        // the name of the command (the part after "bin/console")
        ->setName('make:block')

        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a new simple block.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a block...')
        ->addArgument('blockname', InputArgument::REQUIRED, 'The name of block')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $output->writeln([
            'Block Creator',
            '============',
        ]);
        $output->writeln('Creating block '.$input->getArgument('blockname'));

        $name = $input->getArgument('blockname');
        $tag = $this->from_camel_case($name);

        $dir_class = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."Blocks".DIRECTORY_SEPARATOR.$name;
        $dir_twig = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$name;
        $dir_config = __DIR__.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."config";

        $this->createDirectory($dir_class);
        $this->createDirectory($dir_twig);

        $rep = [
            '{NAME}' => $name,
            '{TAG}' => $tag,
        ];

        //model, form, manager, twig, config
        $this->createFile($dir_class, $name.".php", $this->patterns['model'], $rep);
        $this->createFile($dir_class, $name."Form.php", $this->patterns['form'], $rep);
        $this->createFile($dir_class, $name."Manager.php", $this->patterns['manager'], $rep);
        $this->createFile($dir_twig, "index.html.twig", $this->patterns['twig'], $rep);
        $this->createFile($dir_config, "block_manager.yaml", $this->patterns['config'], $rep, true);

        $output->writeln('Finito! Good Job!');
    }

    protected function createDirectory($path) {
        if (!\file_exists($path)) {
            mkdir($path, 0777, true);
            $this->output->writeln("Dir $path created...");
        }
    }

    protected function createFile($dir, $filename, $content, $params = [], $append = false) {
        $url = $dir.DIRECTORY_SEPARATOR.$filename;
        if((\file_exists($url) && !$append) || (!\file_exists($url) && $append)) {
            echo "Can not create or edit to $filename file...\n";
            return false;
        }
        foreach($params as $from => $to) {
            $content = str_replace($from, $to, $content);
        }
        if($append) {
            $this->output->writeln("File $filename updated...");
            return \file_put_contents($url, $content, FILE_APPEND);
        }
        $this->output->writeln("File $filename created...");
        return \file_put_contents($url, $content);
    }

    private function from_camel_case($input) {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }

    protected $patterns = [
        'model' => '<?php

namespace App\BlockManager\Blocks\{NAME};

use App\BlockManager\Base\BlockModelInterface;

class {NAME} implements BlockModelInterface {
    public $content;
    
    public function getContent() {
return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }
}
',
    'form' => '<?php

namespace App\BlockManager\Blocks\{NAME};

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\BlockManager\Blocks\{NAME}\{NAME};

class {NAME}Form extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add(\'content\', TextType::class)
            ;
    }
    
    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            \'data_class\' => {NAME}::class,
        ]);
    }
}
',
    'manager' => '<?php

namespace App\BlockManager\Blocks\{NAME};

use App\BlockManager\Base\BlockBase;

class {NAME}Manager extends BlockBase
{
    public function getTwigTemplate() {
        return \'@BlockManagerTemplates/{NAME}/index.html.twig\';
    }
}',
    'twig' => '
{# Provide {NAME} model class as data #}
<div class="wws-block-{TAG}">
    {{data.content|raw}}
</div>
',
    'config' => '
        {TAG}:
            tag: block.{TAG}
            name: {NAME}
            manager: App\BlockManager\Blocks\{NAME}\{NAME}Manager
            model: App\BlockManager\Blocks\{NAME}\{NAME}
            form: App\BlockManager\Blocks\{NAME}\{NAME}Form',
    ];

}
