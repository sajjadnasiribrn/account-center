FROM certbot/certbot:v1.27.0

# Install netcat (works on both Debian- and Alpine-based certbot images)
RUN if command -v apk >/dev/null 2>&1; then \
      apk add --no-cache netcat-openbsd; \
    else \
      apt-get update && apt-get install -y --no-install-recommends netcat-openbsd && rm -rf /var/lib/apt/lists/*; \
    fi

COPY certify-init.sh /opt/certify-init.sh
RUN chmod +x /opt/certify-init.sh

ENTRYPOINT ["/opt/certify-init.sh"]
