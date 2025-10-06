<?php
// NavbarControler.php
// Controlador para lógica de navegação e exibição de menus

class NavbarControler {
    public function getMenu($tipoUsuario) {
        // Retorna itens de menu conforme o tipo de usuário
        if ($tipoUsuario === 'admin') {
            return ['Dashboard', 'Usuários', 'Publicações', 'Sair'];
        } else {
            return ['Início', 'Minhas Publicações', 'Perfil', 'Sair'];
        }
    }
}
