plugin:
  name: SMM Manager
  version: v1.0.0
  description: >
    A powerful plugin for the Nextpost panel to manage SMM service orders (create, refill, cancel, check status)
    with support for APIs like Crescitaly.
  panel: Nextpost Instagram Panel
  author: Onelab
  contact: hello@onelab.co
  license: Private Use Only

features:
  - API Integration with Crescitaly & other SMM providers
  - Auto Order on Account Creation
  - Manual Order Support
  - Refill Management
  - Cancel Order
  - Status Checking
  - Clean UI (AJAX)
  - MVC Structure
  - License Validation Ready

structure:
  root: plugins/smm-manager/
  folders:
    - controllers/
    - core/providers/
    - models/
    - views/partials/
    - assets/js/
    - assets/css/
  files:
    - config.json
    - LICENSE

installation:
  steps:
    - Upload `smm-manager/` to the `plugins/` directory
    - Activate plugin via admin panel or run SQL:
      sql: |
        INSERT INTO np_plugins (idname, is_active)
        VALUES ('smm-manager', 1);
    - Import required tables (adjust schema as per your DB):
      sql: |
        CREATE TABLE np_smm_orders (...);
        CREATE TABLE np_smm_refills (...);
    - Configure settings:
        - API Key
        - API URL
        - Default Service ID
        - Auto Order toggle
        - Custom Quantity (optional)

usage:
  automatic_order:
    description: >
      Automatically creates SMM orders when a user account is created, if auto-order is enabled.
  manual_order:
    description: >
      Admins can create orders manually by choosing service, link, and quantity.
  actions:
    - Refill Order
    - Cancel Order
    - Check Status

license_protection:
  enabled: true
  method:
    - Add a remote license validator script
    - Check inside plugin controller:
      code: |
        if (!License::isValid()) {
            exit("Unauthorized use. License invalid.");
        }

credits:
  developer: Onelab
  website: https://crescitaly.com
  license: >
    This plugin is licensed for private use only.
    Redistribution or resale is strictly prohibited.
  support:
    email: hello@onelab.co
    docs: Included in the plugin folder
    github_issues: true

metadata:
  readme_format: markdown
  yaml_ready: true
