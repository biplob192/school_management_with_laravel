<?php

namespace App\Services;

use Exception;
use App\Models\User;
use App\DataTransferObjects\PaginateData;


class UserService
{
    public function formateDataForIndexWithPaginate($request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('perPage', 10);
            $search = $request->get('search', null);
            $sortKey = $request->get('sort_key', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');

            // Predefined select fields (columns to be selected)
            $selectFields = [];

            // Predefined relations
            // $withRelations = ['package_info:id,name', 'paymentMethodInfo:id,name', 'employer_info:id,company_name', 'refunded_amounts'];
            $withRelations = ['roles', 'student.class'];

            // Define the relational model and their fields to search in relation
            $relationModelSearch = [
                // ['model_relation' => 'package_info', 'searchable_column' => 'name'],
                // ['model_relation' => 'employer_info', 'searchable_column' => 'company_name'],
            ];

            // Basic conditions (e.g., is_active)
            $conditions = [
                ['column' => 'is_active', 'operator' => '=', 'value' => 1],
                // Add more simple conditions as needed
            ];

            // Define and collect date conditions (e.g., created_at)
            $dateFilterColumns = ['created_at'];
            $filterWithDates   = [];

            foreach ($dateFilterColumns as $column) {
                if ($request->has($column)) {
                    $filterWithDates[$column] = $request->get($column);
                }
            }

            // Searchable columns for the main search
            $searchableColumns = ['name', 'email', 'phone'];

            // Define special searchable columns for specific column-based search
            $specialSearchableColumns = ['email', 'phone'];

            // Collect any special search fields
            $specialSearch = [];
            foreach ($specialSearchableColumns as $column) {
                if ($request->has($column)) {
                    $specialSearch[$column] = $request->get($column);
                }
            }

            // Custom condition filters (e.g., for "not equal", "greater than")
            $customConditions = [];
            // if ($request->has('status')) {
            //     $customConditions[] = ['column' => 'status', 'operator' => '=', 'value' => $request->get('status')];
            // }
            // if ($request->has('price_min')) {
            //     $customConditions[] = ['column' => 'price', 'operator' => '>=', 'value' => $request->get('price_min')];
            // }
            // if ($request->has('price_max')) {
            //     $customConditions[] = ['column' => 'price', 'operator' => '<=', 'value' => $request->get('price_max')];
            // }


            return new PaginateData(
                $page,
                $perPage,
                $search,
                $sortKey,
                $sortOrder,
                $selectFields,
                $withRelations,
                $relationModelSearch,
                $conditions,
                $filterWithDates,
                $customConditions,
                $searchableColumns,
                $specialSearch
            );
        } catch (Exception $e) {
            throw new Exception("Error formating data for indexWithPaginate: " . $e->getMessage(), $e->getCode() ? $e->getCode() : 500);
        }
    }


    public function ajaxDestroy($id)
    {
        try {
            if (User::find($id)->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => "Deleted successfully.",
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function ajaxShow($id)
    {
        try {
            $record = User::findOrFail($id);

            if ($record) {
                return response()->json([
                    'success' => true,
                    'message' => "Record retrieved successfully.",
                    'data'    => $record,
                ], 200);
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
