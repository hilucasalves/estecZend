<?php

namespace Usuario\Permissoes;

use Zend\Permissions\Acl\Acl as ClassAcl;
use Zend\Permissions\Acl\Role\GenericRole as Papel;
use Zend\Permissions\Acl\Resource\GenericResource as Recurso;

class Acl extends ClassAcl {

    protected $papeis;
    protected $recursos;
    protected $permissoes;

    public function __construct(array $papeis, array $recursos, array $permissoes) {
        $this->papeis = $papeis;
        $this->recursos = $recursos;
        $this->permissoes = $permissoes;

        $this->loadPapeis();
        $this->loadRecursos();
        $this->loadPermissao();
    }

    protected function loadPapeis() {
        foreach ($this->papeis as $papel) {
            $this->addRole(new Papel($papel->__get('nome')));
        }
    }

    protected function loadRecursos() {
        foreach ($this->recursos as $recurso) {
            $this->addResource(new Recurso($recurso->getNome()));
        }
    }

    protected function loadPermissao() {
        foreach ($this->permissoes as $permissao) {
            if ($permissao->__get('permitido') == 1) {
                $this->allow($permissao->getUsuarioTipo()->__get('nome'), $permissao->__get('recurso')->__get('controle')->__get('nome'), $permissao->getRecurso()->__get('acao')->__get('nome'));
            } else {
                $this->deny($permissao->getUsuarioTipo()->__get('nome'), $permissao->__get('recurso')->__get('controle')->__get('nome'), $permissao->getRecurso()->__get('acao')->__get('nome'));
            }
        }
    }

}
