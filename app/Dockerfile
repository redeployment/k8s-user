
FROM centos:7

ENV WORK_DIR /var/www/html

WORKDIR ${WORK_DIR}
COPY . ${WORK_DIR}

RUN chmod -R 777 storage/ bootstrap/cache/
