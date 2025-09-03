<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use phpDocumentor\Reflection\Types\Boolean;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('content'),
            TextField::new('author', 'Auteur')->onlyOnIndex(),
            AssociationField::new('article'),
            AssociationField::new('reviews', 'Review')->onlyOnIndex(),
            DateTimeField::new('created_at')
                ->setFormat('dd/MM/YYYY HH:mm'), 
            BooleanField::new('is_moderated', 'Modéré')->onlyOnIndex(),
            BooleanField::new('is_published', 'Publié')->onlyOnIndex(),
        ];
    }
    
}
