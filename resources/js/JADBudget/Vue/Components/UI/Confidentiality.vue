<template>
    <div class="confidentialityPolicies">
        <div class="box">
            <h1>Politique de confidentialité</h1>
            <span></span>
            <p>
                La présente Politique de Confidentialité décrit la manière dont JADeveloppement collecte, utilise et protège les 
                informations que vous fournissez lorsque vous utilisez notre formulaire de contact sur le site web <a href="#">jadeveloppement.fr</a>
            </p>
            <span></span>
            <h2>Collecte des Données Personnelles</h2>
            <span></span>
            <p>
                JADeveloppement s'engage à minimiser la collecte de données personnelles. Lors de l'utilisation de notre formulaire 
                de contact, la seule information que nous collectons est votre adresse e-mail.
                <br><br>
                Nous ne collectons aucune autre donnée personnelle, telle que votre nom, prénom, numéro de téléphone, adresse IP, 
                ou toute autre information d'identification, à travers ce formulaire.
            </p>
            <span></span>
            <h2>Finalité de la Collecte</h2>
            <p>
                Votre adresse e-mail est collectée dans un unique but : nous permettre de vous recontacter pour répondre à votre 
                demande soumise via le formulaire de contact.
                <br><br>
                Nous n'utilisons pas votre adresse e-mail à des fins de marketing direct, d'envoi de newsletters, ou pour toute autre 
                communication non sollicitée.
            </p>
            <span></span>
            <h2>Non-Enregistrement et Durée de Conservation des Données</h2>
            <p>
                Nous tenons à vous informer que votre adresse e-mail n'est pas enregistrée ni stockée de manière permanente dans une 
                base de données ou un fichier. L'adresse e-mail est utilisée uniquement pour les échanges nécessaires à la réponse à 
                votre demande. Une fois la communication terminée et votre demande traitée, 
                votre adresse e-mail n'est pas conservée par nos systèmes au-delà de la durée de l'échange.
            </p>
            <span></span>
            <h2>Non-Partage et Non-Vente des Données</h2>
            <p>
                Votre adresse e-mail, collectée via le formulaire de contact, n'est en aucun cas vendue, louée, partagée ou cédée à 
                des tiers.
            </p>
            <span></span>
            <h2>Cookies et Traceurs</h2>
            <p>
                JADeveloppement ne dépose aucun cookie ni traceur sur votre appareil lorsque vous visitez notre site web. Nous ne 
                collectons aucune information de navigation, statistique ou comportementale vous concernant.
            </p>
            <span></span>
            <h2>Vos Droits</h2>
            <p>
                Conformément au Règlement Général sur la Protection des Données (RGPD), bien que nous ne stockions pas vos données de 
                manière permanente, vous disposez des droits suivants concernant les informations que vous nous communiquez :
                <br><br>
                <b style='margin-left: 0.5rem'>Droit d'accès : </b>Demander l'accès aux données personnelles que nous détenons (dans le 
                cadre de nos échanges actifs). <br>
                <b style='margin-left: 0.5rem'>Droit de rectification : </b>Demander la correction de toute information inexacte vous concernant. <br>
                <b style='margin-left: 0.5rem'>Droit à l'effacement : </b>Demander la suppression de vos données (applicables si nous les stockions
                de manière permanente). <br>
                <b style='margin-left: 0.5rem'>Droit d'opposition : </b>Vous opposer au traitement de vos données. <br>
                <br>
                Pour exercer ces droits, ou pour toute question concernant notre Politique de Confidentialité, vous pouvez nous contacter à 
                l'adresse e-mail suivante : <a href="mailto:contact@jadeveloppement.fr">contact@jadeveloppement.fr</a>
            </p>
            <span></span>
            <h2>Modifications de la Politique de Confidentialité</h2>
            <p>
                La présente Politique de Confidentialité pourra être modifiée ou complétée à tout moment par JADeveloppement, 
                notamment en vue de se conformer à toute évolution législative, réglementaire, jurisprudentielle ou technologique. 
                Nous vous encourageons à consulter régulièrement cette page pour prendre connaissance des éventuelles 
                modifications.
            </p>
        </div>
    </div>
</template>

<style scoped>
    span {
        margin-top: 1rem;
    }
</style>

<script>
    export default {
        mounted(){
            const confidentialityPolicies = document.querySelector('.confidentialityPolicies');
            confidentialityPolicies.addEventListener('click', () => {
                confidentialityPolicies.style.top = "100vh";
            })
        }
    }
</script>