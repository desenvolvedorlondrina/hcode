INSERT INTO
    tb_countries (id_country, num_ibge_country, des_country, des_coi, num_ddi)
VALUES
    (1, NULL, 'D', 'C', NULL);

INSERT INTO
    tb_states (id_state, id_country, num_ibge_state, des_state, des_uf)
VALUES
    (1, 1, NULL, 'S', 'U');

INSERT INTO
    tb_cities (id_city, id_state, num_ibge_city, des_city, num_ddd, dt_city_created_at)
VALUES
    (1, 1, NULL, 'C', NULL, NOW());

INSERT INTO
    tb_street_types (id_street_type, des_street_type, des_acronym)
VALUES
    (1, 'S', NULL);

INSERT INTO
    tb_contacts (id_contact, des_contact, des_contact_email, num_contact_phone, des_contact_subject, des_message, dt_contact_created_at)
VALUES
    (1, 'C', 'E', NULL, 'S', 'M', NOW());

INSERT INTO
    tb_persons (id_person, des_person, des_email, des_cpf, num_phone, bin_photo)
VALUES
    (1, 'P', NULL, NULL, NULL, NULL);

INSERT INTO
    tb_users (id_user, id_person, des_login, des_password, is_admin, dt_user_created_at, dt_user_changed_in)
VALUES
    (1, 1, 'L', 'P', 1, NOW(), NULL);

INSERT INTO
    tb_users_logs (id_log, id_user, des_log, des_device, des_user_agent, des_php_session_id, des_source_url, des_url, dt_log_created_at)
VALUES
    (1, 1, 'L', NULL, 'U', 'P', NULL, 'U', NOW());

INSERT INTO
    tb_mails (id_mail, des_recipient_email, des_recipient_name, des_subject, des_content, des_files, is_sent, dt_mail_created_at, dt_mail_changed_in)
VALUES
    (1, 'E', 'N', 'S', 'C', NULL, 0, NOW(), NULL);

INSERT INTO
    tb_users_passwords_recoveries (id_recovery, id_user, des_ip, des_security_key, dt_recovery_created_at, dt_recovery)
VALUES
    (1, 1, 'I', 'K', NOW(), NULL);

INSERT INTO
    tb_addresses (id_address, id_person, id_city, id_street_type, des_address, des_number, des_district, des_complement, des_reference, num_zip_code, dt_address_created_at, dt_address_changed_in)
VALUES
    (1, 1, 1, NULL, 'A', 0, NULL, 'C', NULL, 0, NOW(), NULL);

INSERT INTO
    tb_products (id_product, des_product, des_description, bin_image, vl_price, vl_width, vl_height, vl_length, vl_weight, num_quantity_stock, is_national, des_slug, dt_product_created_at, dt_product_changed_in)
VALUES
    (1, 'P', NULL, NULL, 0.0, 0.0, 0.0, 0.0, 0.0, 0, 0, 'S', NOW(), NULL);

INSERT INTO
    tb_categories (id_category, des_category, des_nickname, fk_category, dt_category_created_at, dt_category_changed_in)
VALUES
    (1, 'C', 'N', NULL, NOW(), NULL);

INSERT INTO
    tb_products_categories (id_product, id_category, dt_category_added_at)
VALUES
    (1, 1, NOW());

INSERT INTO
    tb_wishlist (id_user, id_product, dt_product_added_at)
VALUES
    (1, 1, NOW());

INSERT INTO
    tb_carts (id_cart, des_session_id, id_user, id_address, num_temporary_zip_code, vl_freight, des_type_freight, num_days, is_own_delivery, dt_cart_created_at)
VALUES
    (1, 'S', NULL, NULL, NULL, NULL, NULL, NULL, 0, NOW());

INSERT INTO
    tb_carts_products (id_cart_product, id_cart, id_product, vl_unit_price, dt_removed, dt_added_to_cart)
VALUES
    (1, 1, NULL, 0.0, NULL, NOW());

INSERT INTO
    tb_orders_status (id_status, des_status, num_code, dt_status_created_at)
VALUES
    (1, 'S', 1, NOW());

INSERT INTO
    tb_orders (id_order, id_cart, id_user, id_status, id_address, vl_total, des_code, des_annotation, dt_order_created_at)
VALUES
    (1, 1, 1, 1, 1, 0.0, 'C', NULL, NOW());

INSERT INTO
    tb_topics_types (id_type, des_type, des_summary, des_route, dt_type_created_at)
VALUES
    (1, 'T', NULL, 'R', NOW());

INSERT INTO
    tb_topics (id_topic, id_type, des_topic, dt_topic_created_at)
VALUES
    (1, 1, 'T', NOW());

INSERT INTO
    tb_subtopics (id_subtopic, id_topic, id_type, des_subtopic, des_text, dt_subtopic_created_at, dt_subtopic_changed_in)
VALUES
    (1, 1, NULL, 'S', 'T', NOW(), NULL);