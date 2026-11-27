#!/usr/bin/env bash
set -e

# Build and start all services (App + WAF ModSecurity + ModWAF Dashboard)
docker compose build php modsec-dashboard
docker compose up -d

# Ensure the non-root WAF worker can write to the shared audit log volume
docker compose exec -u root waf-modsecurity chmod 777 /var/log/modsecurity/audit
docker compose exec -u root waf-modsecurity touch /var/log/modsecurity/audit/audit.log
docker compose exec -u root waf-modsecurity chmod 666 /var/log/modsecurity/audit/audit.log
docker compose restart waf-modsecurity
