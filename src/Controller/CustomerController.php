<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\UserBundle\CustomerCrudService;
use App\Service\UserBundle\CustomerMapper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * controller for customer api requests
 *
 * @author    Julian Engler <info@julian-engler.de>
 * @package   App\Controller
 * @version   1.0.0
 * @since     1.0.0
 *
 * @Route("/foo/kunden", name="api_customer")
 */
class CustomerController extends AbstractController
{
    /**
     * @var \App\Service\UserBundle\CustomerCrudService
     */
    protected CustomerCrudService $customerCrudService;

    /**
     * @var \App\Service\UserBundle\CustomerMapper
     */
    protected CustomerMapper $customerMapper;

    /**
     * @param \App\Service\UserBundle\CustomerCrudService $userCrudService
     * @param \App\Service\UserBundle\CustomerMapper $customerMapper
     */
    public function __construct(CustomerCrudService $userCrudService, CustomerMapper $customerMapper)
    {
        $this->customerCrudService = $userCrudService;
        $this->customerMapper = $customerMapper;
    }

    /**
     * @Route("/", methods={"GET"}, name="list_customer")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listCustomerCollection(): Response
    {
        try {
            $customerCollection = $this->customerCrudService->getActiveCustomerCollection();
            if (empty($customerCollection)) {
                return $this->json([]);
            }

            $mappedData = $this->customerMapper->mapCustomerEntityCollection($customerCollection);
            return $this->json($mappedData);
        } catch (\Throwable $ex) {
            return $this->json([
                'message' => $ex->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="get_customer")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getCustomer(int $id): Response
    {
        try {
            $customer = $this->customerCrudService->getActiveCustomerById($id);
            if ($customer == null) {
                return $this->json([]);
            }

            $mappedData = $this->customerMapper->mapCustomerEntity($customer);
            return $this->json($mappedData);
        } catch (\Throwable $ex) {
            return $this->json([
                'message' => $ex->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/", methods={"POST"}, name="create_customer")
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createCustomer(Request $request): Response
    {
        try {
            $data = json_decode((string)$request->getContent(), true);
            $customer = $this->customerCrudService->createCustomer($data);
            if (empty($customer)) {
                return $this->json([]);
            }

            $mappedData = $this->customerMapper->mapCustomerEntity($customer);
            return $this->json($mappedData);
        } catch (\Throwable $ex) {
            return $this->json([
                'message' => $ex->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
