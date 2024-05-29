<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use MapasCulturais\Entities\Term;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class TermFixtures extends Fixture
{
    public const TERM_ID_PREFIX = 'term';
    public const TERMS = '/src/conf/taxonomies.php';

    private SerializerInterface $serializer;

    public function __construct()
    {
        $this->serializer = new Serializer([new ObjectNormalizer()]);
    }

    public function load(ObjectManager $manager): void
    {
        $this->deleteAllDataFromTable(Term::class);

        $termsCollections = (require dirname(__DIR__, 3).self::TERMS) ?? [];
        $terms = $this->mountTerms($termsCollections);

        foreach ($terms as $termData) {
            $term = $this->serializer->denormalize($termData, Term::class);
            $this->setReference(sprintf('%s-%s', self::TERM_ID_PREFIX, $term->id), $term);
            $manager->persist($term);
        }

        $manager->flush();
    }

    public function mountTerms(array $termsCollections): array
    {
        $id = 1;
        $terms = [];

        foreach ($termsCollections as $termCollection) {
            foreach ($termCollection['restricted_terms'] ?? [] as $term) {
                $terms[] = [
                    'id' => $id,
                    'taxonomy' => $termCollection['slug'],
                    'term' => $term,
                    'description' => $termCollection['description'],
                ];
                $id++;
            }
        }

        return $terms;
    }
}
