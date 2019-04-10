# https://hub.docker.com/_/consul
FROM consul:latest


 # support bash shell
RUN apk add --no-cache bash



# Use consul-template to re-write our PHP Service config
ENV CONSUL_TEMPLATE_VERSION 0.20.0

RUN curl  -O https://releases.hashicorp.com/consul-template/${CONSUL_TEMPLATE_VERSION}/consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz \
	 && tar -zxf consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz \
    && mv consul-template /bin \
    && rm consul-template_${CONSUL_TEMPLATE_VERSION}_linux_386.tgz






# get ContainerPilot release
ENV CONTAINERPILOT_VERSION 3.8.0
RUN export checksum=84642c13683ddae6ccb63386e6160e8cb2439c26	 \
    && curl -Lso /tmp/containerpilot.tar.gz \
         "https://github.com/joyent/containerpilot/releases/download/${CONTAINERPILOT_VERSION}/containerpilot-${CONTAINERPILOT_VERSION}.tar.gz" \
    && echo "${checksum}  /tmp/containerpilot.tar.gz" | sha1sum -c \
    && tar zxf /tmp/containerpilot.tar.gz -C /usr/local/bin \
    && rm /tmp/containerpilot.tar.gz






ENV CONTAINERPILOT=/etc/containerpilot.json5

# add config files
# consul service json file 
COPY consul/consul.d/ /consul/config/
# consul template json files
COPY consul/consul-tpl.d/ /etc
# add other confiles 
COPY consul/config/ /etc
# add script files
COPY consul/scripts/ /usr/local/bin
RUN chmod +x /usr/local/bin/reload.sh


CMD ["containerpilot"]



