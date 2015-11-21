<?php

namespace PinterestLike\VendorBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * VendorImageRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class VendorImageRepository extends EntityRepository
{
    /*
     *  TODO - CHANGE EVERYTHING HERE - DIRTY AND QUICK WAY - ADD OTHER LEVEL VENDOR MEDIA LINKED TO VIDEO AND IMAGE
     *   Speed it up using native sql
    */
    public function getAllMedia($params = array())
    {
        /** @var EntityManager $entityManager */
        $connection = $this->getEntityManager()->getConnection();

        // may have performance issues, need to check this later
        $where = '';
        if (!empty($params['search-term'])) {
            $where = " AND (
                vendor_name LIKE :searchTerm
                OR description LIKE :searchTerm
                OR category_name LIKE :searchTerm
            )
            ";
        }

        $stmt = $connection->prepare("
            SELECT *
            FROM (
                SELECT vi.id, 'image' type, '' as video_type, '' as video_id, v.id vendor_id,  v.name vendor_name , vi.image_path, vi.description, vi.created_at
                FROM vendor v
                INNER JOIN vendor_image vi
                    ON v.id = vi.vendor_id
                INNER JOIN category c
                    ON c.id = vi.category_id

                UNION

                SELECT vv.id, 'video' type, vv.video_type, vv.video_id, v.id vendor_id, v.name vendor_name, vv.image_path, vv.description, vv.created_at
                FROM vendor v
                INNER JOIN vendor_video vv
                    ON v.id = vv.vendor_id
                INNER JOIN category c
                    ON c.id = vv.category_id

            ) AS aux
            WHERE 1 = 1
                " . $where . "
            ORDER BY aux.created_at DESC
        ");

        if (!empty($params['search-term'])) {
            $stmt->bindValue('searchTerm', '%' . $params['search-term'] . '%');
        }

        $stmt->execute();

        $result = $stmt->fetchAll();

        return $result;
    }

}
