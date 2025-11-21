<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('items', function (Blueprint $table) {
            // Add index on store_id for multi-tenant queries
            $table->index('store_id', 'idx_items_store_id');
            
            // Add index on category_id for filtering by category
            $table->index('category_id', 'idx_items_category_id');
            
            // Add composite index for common query patterns
            $table->index(['store_id', 'quantity'], 'idx_items_store_quantity');
            
            // Add index for code lookups (unique constraint already creates index)
            // No additional index needed for 'code' as unique constraint creates one
        });

        Schema::table('categories', function (Blueprint $table) {
            // Add index on store_id for multi-tenant queries
            $table->index('store_id', 'idx_categories_store_id');
            
            // Add composite index for name sorting within stores
            $table->index(['store_id', 'name'], 'idx_categories_store_name');
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            // Add index on store_id for multi-tenant queries
            $table->index('store_id', 'idx_stock_movements_store_id');
            
            // Add index on item_id for item history queries
            $table->index('item_id', 'idx_stock_movements_item_id');
            
            // Add index on type for filtering in/out movements
            $table->index('type', 'idx_stock_movements_type');
            
            // Add index on created_at for date range queries
            $table->index('created_at', 'idx_stock_movements_created_at');
            
            // Add composite indexes for common query patterns
            $table->index(['store_id', 'type', 'created_at'], 'idx_stock_movements_store_type_date');
            $table->index(['item_id', 'type'], 'idx_stock_movements_item_type');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            // Add index on store_id for multi-tenant queries
            $table->index('store_id', 'idx_activity_logs_store_id');
            
            // Add index on user_id for user activity tracking
            $table->index('user_id', 'idx_activity_logs_user_id');
            
            // Add index on created_at for recent activity queries
            $table->index('created_at', 'idx_activity_logs_created_at');
            
            // Add composite index for common dashboard queries
            $table->index(['store_id', 'created_at'], 'idx_activity_logs_store_date');
        });

        Schema::table('restock_notifies', function (Blueprint $table) {
            // Add index on store_id for multi-tenant queries
            $table->index('store_id', 'idx_restock_notifies_store_id');
            
            // Add index on item_id for item-specific notifications
            $table->index('item_id', 'idx_restock_notifies_item_id');
        });

        Schema::table('stores', function (Blueprint $table) {
            // slug already has unique constraint which creates an index
            // contact_info already has unique constraint which creates an index
            // No additional indexes needed
        });

        Schema::table('users', function (Blueprint $table) {
            // Add index on store_id for store user queries
            $table->index('store_id', 'idx_users_store_id');
            
            // email already has unique constraint which creates an index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop indexes in reverse order
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_store_id');
        });

        Schema::table('restock_notifies', function (Blueprint $table) {
            $table->dropIndex('idx_restock_notifies_store_id');
            $table->dropIndex('idx_restock_notifies_item_id');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_activity_logs_store_id');
            $table->dropIndex('idx_activity_logs_user_id');
            $table->dropIndex('idx_activity_logs_created_at');
            $table->dropIndex('idx_activity_logs_store_date');
        });

        Schema::table('stock_movements', function (Blueprint $table) {
            $table->dropIndex('idx_stock_movements_store_id');
            $table->dropIndex('idx_stock_movements_item_id');
            $table->dropIndex('idx_stock_movements_type');
            $table->dropIndex('idx_stock_movements_created_at');
            $table->dropIndex('idx_stock_movements_store_type_date');
            $table->dropIndex('idx_stock_movements_item_type');
        });

        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('idx_categories_store_id');
            $table->dropIndex('idx_categories_store_name');
        });

        Schema::table('items', function (Blueprint $table) {
            $table->dropIndex('idx_items_store_id');
            $table->dropIndex('idx_items_category_id');
            $table->dropIndex('idx_items_store_quantity');
        });
    }
};
