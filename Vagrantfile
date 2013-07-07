Vagrant::Config.run do |config|
    config.vm.box = "php-ci"
    config.vm.box_url = "http://static.jubianchi.fr/boxes/php-ci.box"

    config.vm.customize ["modifyvm", :id, "--memory", 1024]

    # Comment the following lines if your OS does not support NFS
    config.vm.network :hostonly, "10.0.0.2"
    config.vm.share_folder("v-root", "/vagrant", ".", :nfs => true)

    config.vm.auto_port_range = 8000..9000
    config.vm.forward_port 8080, 8181, :auto => true
    config.vm.forward_port 9000, 9001, :auto => true
end
